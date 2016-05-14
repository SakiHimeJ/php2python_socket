#coding:utf-8
"""
Socket 服务器端
    常见的协议及端口(这些端口是由操作系统管理的)
    ftp-Data:20,
    ftp-Control:21
    SSH:22,
    Telnet:23
    SMTP:25,
    HTTP:80
    POP3:110
    IMAP:143
    HTTPS:443
"""
import socket
import threading
import time
import queue
 
'''
    任务线程
'''
class TaskThread(threading.Thread):
 
    """
        初始化
    """
    def __init__(self,q):
        threading.Thread.__init__(self)
        self.q = q
    '''
     执行线程
    '''
    def run(self):
        task = self.q.get() #取出一项任务
        self.doTask(task)
        self.q.task_done() #完成任务信号
    '''
        做任务
    '''
    def doTask(self,task):
        print("正在执行任务，内容：%s"%task)
        """path = './task/'+task+'.txt'
        fp = open(path,'w')
        fp.write(task)
        fp.close()"""

def main():
    print('开始监听端口(9999):');
    #Socket
    s = socket.socket(socket.AF_INET,socket.SOCK_STREAM) #创建tcp socket
    s.bind(('localhost',9999))#绑定到9999
    s.listen(5) #监听，但只能挂起5以下链接
 
    #创建队列
    q = queue.Queue()
     
    while True:
        client,addr = s.accept()#连接
        addr = str(addr)
        print("从 %s 获取一个连接"%addr) #直接输出到控制台
        task = str(client.recv(1024).decode())
        timestr = time.ctime(time.time())+"\r\n" #时间羽化输出
        strs =  'python端已接收，任务内容： '+task+"\r\n"
        strs += '现在是：'+timestr
        client.send(strs.encode()) #发送输数据

        cs = '%s 客户端返回的数据为：%s'%(addr,task) #接收客户端数据
        print(cs)
        client.close()
 
        #任务
        task = task.split('|')
        #将任务写入到队列中
        for i in task:
            q.put(i)
 
        #开始线程,多线程同时处理任务
        for i in task:
            t = TaskThread(q)
            t.setDaemon(True) #子线程随主线程一起退出
            t.start() #启动线程
            t.join(10) #保证每个线程运行，但只等10s
 
        q.join() #等所有任务都处理后，再退出
             
if __name__ =='__main__':
    main()