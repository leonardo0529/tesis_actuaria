import yfinance as yf
import sys
import numpy as np
import pandas as pd
from math import sqrt
def change(compañia):
    cambios=[("ñ",'&ntilde'),("á",'&atilde'),
    ("é",'&etilde'),("í",'&itilde'),("ó",'&otilde'),("ú",'&utilde')]
    for c,v in cambios:
        compañia=compañia.replace(c,v)
    return compañia
datos=sys.argv[1:]
symbols= datos[0]
symbols=symbols[1:-1].split(",")
compañias=datos[1]
compañias=compañias[1:-1].split(",")
compañias=list(map(change,compañias))
class portfolio:
    def __init__(self,symbols):
        self.symbs=sorted(symbols)
    def get_info_compamys(self):
        data=yf.download(tickers=self.symbs, start='2019-6-1',progress=0)
        data=data.dropna(axis=0)
        data=data[['Open', 'Close', 'High', 'Low']]
        return data
    @property
    def Close(self):
        return self.get_info_compamys()['Close']
    def matriz_rendimientos(self):
        def rendimiento(comp): return np.diff(np.log(comp))*100
        df_rend=self.Close.apply(rendimiento,axis=0)
        df_rend.columns.name='Empresa'
        return df_rend
    def rend_volt_anual(self):
        rendimientos=self.matriz_rendimientos()
        medias=pd.DataFrame(rendimientos.mean()*365)
        varianzas=pd.DataFrame(rendimientos.std()*sqrt(len(rendimientos)*360/(len(rendimientos)+1)))
        df=pd.merge(medias,varianzas,on='Empresa')
        df.columns=["Media","Varianza"]
        return df
my_portfolio=portfolio(symbols)
varianzas=list(my_portfolio.rend_volt_anual()['Varianza'])
Matriz_Si=[[0]*len(varianzas) for i in range(len(varianzas))]
for i,s_i in zip(range(len(Matriz_Si)),range(len(varianzas))):
                Matriz_Si[i][s_i]=varianzas[s_i]
Matriz_Si=pd.DataFrame(Matriz_Si)
Matrizcorr=my_portfolio.matriz_rendimientos().corr()
Matrizcorr.columns.name=""
Matrizcorr.index.name=""
Matrizcorr.columns=[n for n in range(len(symbols))]
Matrizcorr.index=[n for n in range(len(symbols))]
MVC=Matriz_Si@Matrizcorr@Matriz_Si.T
n=len(MVC)
MVCA=MVC
MVCA.loc[n]=[1]*n
MVCA=MVCA.T
MVCA.loc[n]=[1]*n+[0]
MVCA=MVCA.T
MVCA_inv=np.linalg.inv(MVCA)
def sigmaW(Porc_w): return sqrt(Porc_w.T@np.array(MVC[:-1])@Porc_w)
Vector_B=np.array([0]*n+[1]).reshape(n+1,1)
W_min_riesgo=MVCA_inv@Vector_B
Vector_B=np.array([0]*n+[1]).reshape(n+1,1)
# cmr=pd.DataFrame(W_min_riesgo[:-1])
# cmr.columns=["Ponderaciones"]
# cmr.index=compañias
# cmr.index.name='Compa&ntildeia'
for c,p in zip(compañias,(W_min_riesgo[:-1])):
    print('Compa&ntildeia Ponderaci&otilden')
    print("\n")
    print(c,p[0])
    print("\n")
