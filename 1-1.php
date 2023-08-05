> 环境：windows10


## 1.1、用git克隆到本地

~~~shell
git clone https://gitee.com/sheep-are-flying-in-the-sky/laoyangzhixuewang.git
~~~

![image-20220228090231051](https://cdn.laoyangzhijia.com/my-picture-master/pic15/image-20220228090231051.png)





## 1.2、安装环境

- JDK 1.8   
- MySQL 5.7
- Maven 3.8.3
- Nginx 1.20.2
- Nacos 1.4.1
- Nodejs 14.16.0



## 1.3、导入后端代码

~~~
使用IDEA打开：after_code下的文件夹laoyangzhixuewang
~~~

<img src="https://cdn.laoyangzhijia.com/my-picture-master/pic15/image-20220228091011678.png" alt="image-20220228091011678" style="zoom: 67%;" />





## 1.4、将sql文件导入mysql数据库

> windows数据库安装教程：https://blog.csdn.net/weixin_44537669/article/details/114076961



- 1、登录mysql

~~~
mysql -u账号 -p密码
~~~



- 2、创建数据库

~~~mysql
create database laoyangzhixuewang
~~~



- 3、导入sql文件

~~~mysql
#到项目目录下执行
mysql -u账号 -p密码 laoyangzhijia < laoyangzhijia.sql
~~~

![image-20220228091335782](https://cdn.laoyangzhijia.com/my-picture-master/pic15/image-20220228091335782.png)







## 1.5、启动Nacos
> 访问 http://localhost:8848/nacos/#/login

![image-20220228091624176](https://cdn.laoyangzhijia.com/my-picture-master/pic15/image-20220228091624176.png)



## 1.6、配置Nginx的config文件

<img src="https://cdn.laoyangzhijia.com/my-picture-master/pic15/image-20220228091734696.png" alt="image-20220228091734696" style="zoom: 67%;" />

---

~~~nginx
events {
    worker_connections  1024;
}

http {
    include       mime.types;
    default_type  application/octet-stream;
	client_max_body_size 1024M;                    #上传文件大小限制
    sendfile        on;
    keepalive_timeout  65;
    server {
        listen       80;
        server_name  localhost;

        location / {
            root   html;
            index  index.html index.htm;
			proxy_pass                          http://127.0.0.1:3000;
        }
		
		 location /new {
           #此为新应用index,static目录，同时注意这里是alias,不是root，还有以及new的后面有/结尾
                alias html/new/;
                try_files $uri $uri/ /new/index.html;
                index index.html index.htm;
              
        }

        error_page   500 502 503 504  /50x.html;
        location = /50x.html {
            root   html;
        }

        location ~ /eduservice/ {
           proxy_pass   http://127.0.0.1:8001;
        }

        location ~ /eduoss/fileoss/ {
           proxy_pass   http://127.0.0.1:8002;
        }
		
		location ~ /service/vod/ {
           proxy_pass   http://127.0.0.1:8003;
        }
		
		location ~ /msm/send/ {
           proxy_pass   http://127.0.0.1:8005;
        }
		
		location ~ /api/ucenter/ {
           proxy_pass   http://127.0.0.1:8160;
        }
		
		location ~ /eduorder/ {
           proxy_pass   http://127.0.0.1:8007;
        }
		
		location ~ /statservice/ {
           proxy_pass   http://127.0.0.1:8008;
        }
    }
}
~~~



## 1.7、启动微服务

<img src="https://cdn.laoyangzhijia.com/my-picture-master/pic15/image-20220228091938704.png" alt="image-20220228091938704" style="zoom:50%;" />

## 1.8、启动：前端（前台）

- 进入：front_next的（下一级）template目录

![image-20220228092046548](https://cdn.laoyangzhijia.com/my-picture-master/pic15/image-20220228092046548.png)

![image-20220228092243183](https://cdn.laoyangzhijia.com/my-picture-master/pic15/image-20220228092243183.png)



- cmd执行命令

~~~nodejs
npm install     #安装依赖
npm run build   #打包
npm run start   #启动项目
~~~



- 查看效果

> 访问：localhost:3000

![image-20220228092808405](https://cdn.laoyangzhijia.com/my-picture-master/pic15/image-20220228092808405.png)



## 1.9、启动：前端（后台）

- 进入front_vue_admin目录

![image-20220228092902611](https://cdn.laoyangzhijia.com/my-picture-master/pic15/image-20220228092902611.png)



- 修改文件1

  ![image-20220228093911547](https://cdn.laoyangzhijia.com/my-picture-master/pic15/image-20220228093911547.png)



- 修改文件2

![image-20220228094008540](https://cdn.laoyangzhijia.com/my-picture-master/pic15/image-20220228094008540.png)



- 修改文件3（替换script）

![image-20220228094120653](https://cdn.laoyangzhijia.com/my-picture-master/pic15/image-20220228094120653.png)

~~~javascript
<script src= "<%= BASE_URL %>/tinymce4.7.5/tinymce.min.js"></script>
<script src= "<%= BASE_URL %>/tinymce4.7.5/langs/zh_CN.js"></script>
~~~



- 执行命令

~~~
npm install     #安装依赖
npm run build   #打包
npm run start   #启动项目
~~~



- 看效果

> http://localhost:9528/

<img src="https://cdn.laoyangzhijia.com/my-picture-master/pic15/image-20220228094318661.png" alt="image-20220228094318661" style="zoom:67%;" />