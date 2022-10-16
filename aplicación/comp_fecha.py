import sys
from datetime import date as dt
date_input=sys.argv[1:]
date_input=date_input[0].split("-")
year=int(date_input[0])
mounth=int(date_input[1])
day=int(date_input[2])
today=dt.today()
fecha_input=dt(year,mounth,day)
resta=(today-fecha_input).days
print(int(resta/365>=18))
