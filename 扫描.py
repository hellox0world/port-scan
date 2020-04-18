import pymysql
import os
import re
import socket,time
from threading import Thread
import win32api, win32con


id=[]
port_1=[]
port_3=[]

#从数据库中查询出对应的危险端口
def sql_1():
    # 打开数据库连接
    db = pymysql.connect("127.0.0.1", "ppq", "123456", "port", port=3306, charset='utf8')
    # 使用 cursor() 方法创建一个游标对象 cursors
    cursor = db.cursor()
    sql = "select * from port"
    # 使用 execute()  方法执行 SQL 查询
    try:
        cursor.execute(sql)
        results = cursor.fetchall()
        for i in results:
            id_1= i[0]
            number = i[1]
            name = i[2]
            grade = i[3]
            describes = i[4]
            # if(grade=='high'):
            #   print(id00,'端口：',number,'名称：',name,'危险等级：',grade,'描述：',describes)
            id.append(id_1)
            port_1.append(number)

    except Exception as e:
        db.rollback()
        # 如果出错就回滚并且抛出错误收集错误信息。
        print("Error!:{0}".format(e))
    # 关闭数据库连接
    finally:
        db.close()

# 定义 portscan 函数，用来进行 TCP 端口扫描
def portscan(target, port_2):
    try:
        # 创建一个 socket:
        client = socket.socket(socket.AF_INET, socket.SOCK_STREAM)
        # 建立连接:
        client.connect((target, port_2))
        # 将端口存入数组
        port_3.append(port_2)
        # 显示连接结果
        #print("[*] %s:%d 开放" % (target, port_2))
        # 关闭连接
        client.close()
    except:
        pass

def sql_2(port):
    warnn = []
    po=[]
    db = pymysql.connect("127.0.0.1", "ppq", "123456", "port", port=3306, charset='utf8')
    cursor = db.cursor()
    sql = "select * from port where number =%s" % (port)
    # 使用 execute()  方法执行 SQL 查询
    try:
        cursor.execute(sql)
        results = cursor.fetchall()
        for i in results:
            id00 = i[0]
            number = i[1]
            name = i[2]
            grade = i[3]
            describes = i[4]
            if (grade == 'high'):
                #print('端口：%-10d'%number,'服务名称：%-10s'%name, '危险等级：%-10s'%grade, '描述：%-10s'%describes)
                warnn='端口：'+str(number)+'服务名称：'+name+ '危险等级：'+grade+'描述：'+describes
                po=number


    except Exception as e:
        db.rollback()
        # 如果出错就回滚并且抛出错误收集错误信息。
        print("Error!:{0}".format(e))
    # 关闭数据库连接
    finally:
        db.close()
    return warnn,po

#危险端口弹窗处理
def warn(warn1,po):
    # 弹出对话框
    win32api.MessageBox(0, "存在危险的开放端口", "警示", win32con.MB_ICONWARNING)
    result = win32api.MessageBox(0, warn1, "危险开放端口详情", win32con.MB_OKCANCEL)    # 返回值为True或者False
    warn1=""
    '''
    if result==1:
        for i in po:
            j=int(i)
            kill_process(j)
    '''
'''
#关闭端口
def kill_process(port):
    print(port)
    ret = os.popen("netstat -nao|findstr " + str(port))
    # 注意解码方式和cmd要相同，即为"gbk"，否则输出乱码
    str_list = ret.read().encode('gbk').decode('gbk')

    ret_list = re.split('', str_list)
    try:
        print(1212)
        process_pid = list(ret_list[0].split())[-1]

        os.popen('taskkill /pid ' + str(process_pid) + ' /F')

        print("端口已被释放")
    except:
        print("端口未被使用")
'''

def main(target):
    i=0
    warnn=[]
    po=[]
    #获取数据库的端口号
    sql_1()
    print('开始扫描：%s' % target)
    # 设置端口
    for port_2 in port_1:
        # 创建多线程
        t = Thread(target=portscan, args=(target, port_2))
        t.start()
        i=i+1
        # 进程维护
        if i % 800 == 0:
            t.join()
    for port in port_3:
        i,j=sql_2(port)
        if (i):
            warnn.append(i)
            po.append(j)

    port_4 = str(port_3)
    ti=str(time.time() - start)
    win32api.MessageBox(0,target+"开放的端口号为"+port_4+"\n\n扫描所用时间为:"+ti, "端口开放情况", win32con.MB_OKCANCEL)
    #print('扫描所用时间为: %.2f 秒' % (time.time() - start))

    if (warnn):
        str1 = '\n'.join(warnn)
        warn(str1,po)


if __name__ == '__main__':
    start = time.time()
    target = "127.0.0.1"
    main(target)


