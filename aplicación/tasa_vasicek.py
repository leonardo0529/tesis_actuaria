#!/usr/bin/env python
# coding: utf-8

# In[4]:


import pandas as pd
import numpy as np
import statsmodels.api as sm
import requests
from  time import localtime as lt
token='80e148cea57213c4d2d88140c1ff90887346c444a5369f04cd72e77229fc632c'
fecha_fin=[str(d) for d in list(lt())[:2]]+["01"]
fecha_fin="-".join(fecha_fin)+"/"
url='https://www.banxico.org.mx/SieAPIRest/service/v1/series/SF282,SF43939,SF3270,SF43945/datos/2000-01-01/'+fecha_fin+'?token='+token
r=requests.get(url)
data=r.json()
cetes_28,cetes_90,cetes_180,cetes_360=data['bmx']['series']
cetes=[cetes_28,cetes_90,cetes_180,cetes_360]
def pd_cetes(data):
    df_cetes=pd.DataFrame(data['datos'])
    df_cetes=df_cetes[df_cetes['dato']!='N/E']
    df_cetes.columns=['fecha','tasa']
    df_cetes=df_cetes['tasa'].astype(float)/100
    return df_cetes
cetes_28,cetes_90,cetes_180,cetes_360=list(map(pd_cetes,cetes))
cetes={28:cetes_28,90:cetes_90,180:cetes_180,360:cetes_360}
def n_tasas(hist,n=1):
    def tasa_vasicek(data):
        var=np.var(data)
        b=np.mean(data)
        delta=np.diff(data)
        lag=data[:-1]
        model=sm.OLS(delta,lag).fit()
        a=-float(model.params)
        norm = np.random.normal(0, var)
        b_0=a*b
        b_1=1-a
        return b_0+b_1*data[-1]+var**(1/2)*norm
    datos=list(hist)
    for i in range(n):
        datos+=[tasa_vasicek(datos)]
    return datos[-n:]

