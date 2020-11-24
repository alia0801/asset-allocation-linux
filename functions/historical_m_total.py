#%%
import sys
import pandas as pd
import numpy as np
import pymysql
import math
import statistics
import time
import datetime
from itertools import combinations, permutations
from scipy.special import comb, perm
# starttime = datetime.datetime.now()
from dateutil.relativedelta import relativedelta

#%%
choose1_raw = str(sys.argv[1])
weight1_raw = str(sys.argv[2])
want_m_raw = int(sys.argv[3])-1
input_per_month_raw = float(sys.argv[4])/12

date1 = int(sys.argv[5])
date2 = int(sys.argv[6])
date3 = int(sys.argv[7])

today = datetime.date(date3,date2,date1)

# choose1_raw = 'SCHP,MINT,VIG,TIP'
# weight1_raw ='0.25,0.25,0.25,0.25'
# want_m_raw = 10
# input_per_month_raw = 10000
# today = datetime.date(2020,10,19)
#%%
check = 0
while check != 1000 :
    try :
        # print("check",check)
        years = ["1990","1991","1992","1993","1994","1995","1996","1997","1998","1999",
                "2000","2001","2002","2003","2004","2005","2006","2007","2008","2009",
                "2010","2011","2012","2013","2014","2015","2016","2017","2018","2019","2020"]
        month = ["00","01","02","03","04","05","06","07","08","09","10","11","12"]
        day = ["00","01","02","03","04","05","06","07","08","09","10",
                    "11","12","13","14","15","16","17","18","19","20",
                    "21","22","23","24","25","26","27","28","29","30","31"]
        day_of_month = [ 31,28,31, 30,31,30, 31,31,30, 31,30,31]
        temp = 'SPY,IVV,VTI,VOO,QQQ,AGG,GLD,VEA,IEFA,BND,VWO,VUG,IWF,LQD,IEMG,VTV,EFA,VIG,IJH,IJR,IWM,VCIT,IWD,VGT,XLK,VO,USMV,IAU,VCSH,BNDX,IVW,HYG,VNQ,VB,ITOT,VYM,BSV,VXUS,VEU,EEM,XLV,TIP,IWB,DIA,SCHX,MBB,IXUS,SHY,SHV,IWR,IGSB,IEF,SCHF,QUAL,VV,GDX,XLF,MUB,TLT,PFF,EMB,IVE,SCHB,XLY,SDY,SLV,GOVT,MDY,BIV,XLP,VT,BIL,JPST,MINT,VBR,RSP,JNK,DVY,IWP,SCHD,VGK,ACWI,SCHP,SCHG,XLI,XLU,DGRO,VMBS,VHT,MTUM,IGIB,IEI,VBK,EFAV,XLC,IWS,GSLC,EWJ,FDN,SCHA'
        temp_arr = temp.split(',')
        etf = []
        for i in range(100):
            etf.append(temp_arr[i])
        temp = 'KO,PLD,CSX,MMC,AAPL,MSFT,AMZN,FB,GOOGL,GOOG,JNJ,V,PG,NVDA,JPM,HD,MA,UNH,VZ,DIS,ADBE,CRM,PYPL,MRK,NFLX,INTC,T,CMCSA,PFE,BAC,WMT,PEP,ABT,TMO,CSCO,MCD,ABBV,XOM,ACN,COST,NKE,AMGN,AVGO,CVX,MDT,NEE,BMY,UNP,LIN,DHR,QCOM,PM,TXN,LLY,LOW,ORCL,HON,UPS,AMT,IBM,SBUX,C,LMT,MMM,WFC,CHTR,RTX,AMD,FIS,BA,NOW,SPGI,BLK,ISRG,GILD,CAT,MDLZ,INTU,MO,ZTS,CVS,TGT,BKNG,AXP,BDX,VRTX,DE,D,ANTM,EQIX,CCI,APD,SYK,CL,TMUS,CI,GS,DUK,MS,ATVI'
        temp_arr = temp.split(',')
        stk = []
        for i in range(100):
            stk.append(temp_arr[i])
        v1 = stk + etf
        # starttime = datetime.datetime.now()
        db = pymysql.connect("localhost", "root", "esfortest", "etf")
        cursor = db.cursor()
        # choose1 = 'SCHP,MINT,VZ,TIP'
        # weight1 ='0.25,0.25,0.25,0.25'
        # want_m = 10
        # input_per_month = 10000
        # choose1 = 'SPY,GOVT,VT,VEA'
        # weight1 ='0.31,0.23,0.23,0.23'
        # want_m = 10
        # input_per_month = 10000
        choose1 = choose1_raw
        weight1 = weight1_raw
        want_m = want_m_raw
        input_per_month = input_per_month_raw
        today = today - datetime.timedelta(days=check)
        yesterday =  today - datetime.timedelta(days=10)
        choose = choose1.split(',')
        # choose = ['VOO','VOE','VT','VEA']
        weight = weight1.split(',')
        # weight = ['0.31','0.23','0.23','0.23']
        for i in range(len(weight)):
            weight[i] = float(weight[i])
        y = 999
        for a in range(len(choose)):
            sql = "select 成立年限 from detail where name = '"+choose[a]+"'"
            # print(sql)
            cursor.execute(sql)
            result_select2 = cursor.fetchall()
            db.commit()
            # print(result_select2)
            if(result_select2[0][0] < y ):
                y = result_select2[0][0]-1
                # y=1
        if((want_m/12) <y):#小於成立年限
            if want_m>37:
                m=want_m
            else:
                m=37
        else:
            m=y*12
        processFee = []
        manageFee = []
        divPer = []
        for i in range(len(choose)):
            sql = "select * from detail where name = '"+choose[a]+"'"
            # print(sql)
            cursor.execute(sql)
            result_select = cursor.fetchall()
            db.commit()
            # print(result_select)
        
            #手續費
            process_fee_percent = 0.1425/100
            processFee.append(process_fee_percent)
            
            #總費用率費(內扣)
            manage_fee = float(result_select[0][5])#從性質表拿總費用率
            manage_fee_day = manage_fee /100/252#每天平均的內扣
            manageFee.append(manage_fee_day)
            # print(manage_fee)
            
            #配息率
            div_percent = result_select[0][8]#從性質表拿配息率
            divPer.append(div_percent)
            # print(div_percent)
        sql = 'select date,'
        for a in range(len(choose)-1):
            sql+=(choose[a]+',')
        sql+= choose[-1] +' FROM `close`'
        # print(sql)
        cursor.execute(sql)
        result_select = cursor.fetchall()
        db.commit()
        # print(result_select)
        df = pd.DataFrame(list(result_select))
        df = df.rename(columns={0:'date'})
        for a in range(len(choose)):
            df = df.rename(columns={a+1:choose[a]})
        for i in range(len(df)):
            have_nan = True
            for a in range(len(choose)):
                if np.isnan(df[choose[a]][i])==True: #是空的
                    have_nan = False
                    break
            if have_nan==False:
                df = df.drop([i],axis=0)
        #今天之前的最後交易日
        todayyy = today
        # todayyy = datetime.date(2020, 8, 16)
        df = df.reset_index(drop=True)
        while (todayyy in list(df['date']))==False and ( datetime.datetime.strptime(str(todayyy),"%Y-%m-%d")>datetime.datetime.strptime(str(df['date'][0]),"%Y-%m-%d") ):
            todayyy -= datetime.timedelta(days=1)
        # print(start_date)
        if (todayyy in list(df['date']))==True:
            todayyy_index = list(df['date']).index(todayyy) 
        else:
            todayyy_index = 0
        df = df[:todayyy_index+1]
        df = df.reset_index(drop=True)
        # m=37
        # m=0
        # moneys = np.zeros(m)#放每月的報酬率
        moneys = []
        in_money_arr=[]#投入總金額
        for i in range(m):
            in_money_arr.append(i*input_per_month)
        part_input =[]
        for i in range(len(choose)):
            part_input.append(input_per_month*weight[i])
        d_now=yesterday
        # d_now = datetime.date(yesterday.year,yesterday.month,3)
        start_date = yesterday - relativedelta(months=m)
        money = [0]*len(choose)
        unit = [0]*len(choose)
        for b in range(m):
            # print("m",m)
            
            
            while (start_date in list(df['date']))==False and ( datetime.datetime.strptime(str(start_date),"%Y-%m-%d")<datetime.datetime.strptime(str(df['date'][len(df)-1]),"%Y-%m-%d") ):
                start_date += datetime.timedelta(days=1)
                # print(start_date)
            if (start_date in list(df['date']))==True:
                start_date_index = list(df['date']).index(start_date) 
            else:
                start_date_index = 0
            final_date = start_date + relativedelta(months=1)
            while (final_date in list(df['date']))==False and ( datetime.datetime.strptime(str(final_date),"%Y-%m-%d")<datetime.datetime.strptime(str(df['date'][len(df)-1]),"%Y-%m-%d") ):
                final_date += datetime.timedelta(days=1)
                # print(final_date)
            if (final_date in list(df['date']))==True:
                final_date_index = list(df['date']).index(final_date) 
            else:
                final_date_index = len(list(df['date']))-1
            for c in range(len(choose)):
                # print("c",c)
                close_now = df[choose[c]][final_date_index]
                close_pre = df[choose[c]][start_date_index]
                input_money = part_input[c]
                if m%12 ==0:
                    div = money*div_percent
                    input_money += div
                process_fee = input_money*processFee[c]
                input_money-=process_fee
                buy_unit = input_money/close_pre
                unit[c] += buy_unit
                money[c] = unit[c] * close_now
                manage = manageFee[c] * day_of_month[(start_date.month)-1] * money[c] 
                money[c] -= manage
                unit[c] = money[c] / close_now
            temp = sum(money)
            moneys.append(temp)
            start_date += relativedelta(months=1)
        #%%
        result = []
        # rewards2 = []
        for x in range(len(moneys)):
            result.append(moneys[x])
            
        #歷史回測圖
        his_fig_rew2=[]
        his_fig_rew = result[:want_m]
        for i in range(len(his_fig_rew)):
            his_fig_rew2.append(format(his_fig_rew[i] , '0.3f'))
        result0 = ' '.join(his_fig_rew2)
        print(result0)
        
        #%%
        count = 0  
        every_reward = []  
        final_ans=[]   
        final_inmoney=[]
        target = [3+1,6+1,12+1,24+1,36+1]
        # target=[]
        for m in target:
            reward_arr = result[len(result)-(m-1):]
            ans = result
            # print(ans)
            final_r = (ans[m-2]-(input_per_month*(m-1)))/(input_per_month*(m-1))
            # print(ans[m-1],input_per_month*m)
            final_r = format(final_r*100 , '0.3f')
            # every_reward[count] = str(final_r)
            # count+=1
            every_reward.append(final_r+'%')
            final_ans.append(format(ans[m-2] , '0.2f'))
            # final_ans.append(str(round(ans[m-1])))
            final_inmoney.append(str(input_per_month*(m-1)))
            # db.close()
        result1 = ' '.join(every_reward)
        result2 = ' '.join(final_ans)
        result3 = ' '.join(final_inmoney)
        print(result1)
        print(result2)
        print(result3)
        
        # print('0')
        # print('0')
        # print('0')
        # print(every_reward)
        # print(choose)
        
        #%%
        endtime = datetime.datetime.now()
        start_years=[2014,2015,2016,2018]
        start_months=[6,12,6,3]
        start_days=[20,17,23,22]
        end_years=[2016,2018,2020,2020]
        end_months=[2,12,7,7]
        end_days=[11,19,28,28]
        result = []
        for a in range(len(start_days)):
        # for a in range(1):
            start_d = datetime.date(start_years[a],start_months[a],start_days[a])
            end_d =  today - datetime.timedelta(days=7)
            vary = relativedelta(end_d,start_d)
            if vary.days<=0:
                result.append('nan')
                continue
            # end_d = datetime.date(end_years[a],end_months[a],end_days[a])
            if( start_d.month < end_d.month ):#足一年
                y = end_d.year - start_d.year
                if(start_d.day < end_d.day):#足一個月
                    # end_ddd = datetime.date(end_d.year,end_d.month,start_d.day)
                    mm = end_d.month - start_d.month
                else:
                    mm = end_d.month - start_d.month -1
            else:
                y = end_d.year - start_d.year-1
                if(start_d.day < end_d.day):#足一個月
                    mm = end_d.month - start_d.month +12
                else:
                    mm = end_d.month - start_d.month +12-1
            # print(y,mm)
            m = y*12 + mm
            # if(start_d.day!=end_d.day):
            m+=1#最後不滿一個月的部分也要算
            # print(m)
            moneys = []
            in_money_arr=[]#投入總金額
            for i in range(m):
                in_money_arr.append(i*input_per_month)
            in_money_arr.append((m-1)*input_per_month)
        
            part_input =[]
            for i in range(len(choose)):
                part_input.append(input_per_month*weight[i])
            d_now=yesterday
            # d_now = datetime.date(yesterday.year,yesterday.month,3)
            money = [0]*len(choose)
            unit = [0]*len(choose)
            # print("m",m)
            start_date = start_d
            for b in range(m+1):
                # print("b",b)
                if b == 0:
                    start_date = start_d
                else:
                    start_date = final_date
                while (start_date in list(df['date']))==False and ( datetime.datetime.strptime(str(start_date),"%Y-%m-%d")<datetime.datetime.strptime(str(df['date'][len(df)-1]),"%Y-%m-%d") ):
                    start_date += datetime.timedelta(days=1)
                    # print(start_date)
                if (start_date in list(df['date']))==True:
                    start_date_index = list(df['date']).index(start_date) 
                else:
                    start_date_index = 0
        
                if b==m:
                    final_date = end_d
                else:
                    final_date = start_date + relativedelta(months=1)
                while (final_date in list(df['date']))==False and ( datetime.datetime.strptime(str(final_date),"%Y-%m-%d")<datetime.datetime.strptime(str(df['date'][len(df)-1]),"%Y-%m-%d") ):
                    final_date += datetime.timedelta(days=1)
                    # print(final_date)
                if (final_date in list(df['date']))==True:
                    final_date_index = list(df['date']).index(final_date) 
                else:
                    final_date_index = len(list(df['date']))-1
                    final_date = df['date'][final_date_index]
        
                for c in range(len(choose)):
                    # print("c",c)
                    close_now = df[choose[c]][final_date_index]
                    close_pre = df[choose[c]][start_date_index]
                    input_money = part_input[c]
                    if m%12 ==0:
                        div = money*div_percent
                        input_money += div
                    process_fee = input_money*processFee[c]
                    input_money-=process_fee
                    buy_unit = input_money/close_pre
                    unit[c] += buy_unit
                    money[c] = unit[c] * close_now
                    manage = manageFee[c] * day_of_month[(start_date.month)-1] * money[c] 
                    money[c] -= manage
                    unit[c] = money[c] / close_now
                temp = sum(money)
                moneys.append(temp)
            result_temp = []
            for x in range(len(moneys)):
                result_temp.append(moneys[x])
            # print(result_temp)
            ans = result_temp
            final_r = (ans[m]-(input_per_month*(m-1)))/(input_per_month*(m-1))
            # print(ans[m-1],input_per_month*m)
            final_r = format(final_r*100 , '0.3f')
            # print(ans)
            # print(final_r+'%')
            # print(format(ans[m] , '0.2f'))
            # print(input_per_month*(m-1))
            result.append(final_r+'%')
        # print(result)
        result4 = ' '.join(result)
        print(result4)
        # endtime2 = datetime.datetime.now()
        check = 1000
    except:
        check = check + 1

db.close()

# %%
