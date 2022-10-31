#!/usr/bin/env python
# coding: utf-8

# In[5]:


import pandas as pd
import numpy as np
import statsmodels.api as sm
def tasa(data,n=1):
    var=data.var()
    b=data.mean()
    delta=np.diff(data)
    lag=data[:-1]
    model=sm.OLS(delta,lag).fit()
    a=-float(model.params)
    mu, sigma = 0,var
    norm = np.random.normal(mu, sigma)
    b_0=a*b
    b_1=1-a
    return b_0+b_1*data.iloc[-1]+var**(1/2)*norm


# In[ ]:




