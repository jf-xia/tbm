# 业务协作管理系统 (协作/任务/时间) - Team/Tasks/Time Bussniss Management System #

## 背景 ##
2015年在公司做运维经理的时候，为了方便管理公司的自研产品信息和相关运维客服售后等业务，做了一个简单的web工具系统用于管理产品和业务工单，后来根据业务需要又加入了项目过程的跟进管理，那时发现公司研发和事业部也希望使用或对接，但系统本身对权限和业务变化的支持能力较弱，所以自2016年11月开始我在业余时间开发了这个系统，使用了Laravel框架（边学边做的，也导致了很多不规范的写法），并通过应用开源社区的各种组件和EAV数据结构的自定义业务单据来适应业务的不断变化。Demo地址: [demo.todo4team.net](http://demo.todo4team.net "demo.todo4team.net") 

## 概况 ##
* 框架：Laravel 5.3 with repositories、laravelcollective/html
* CRUD：infyomlabs/laravel-generator
* 前端：Adminlte、Bootstrap、yajra/laravel-datatables、laravel-u-editor、iCalendar、Select2、fx3costa/laravelchartjs等
* RBAC权限：zizaco/entrust （组织管理需优化）
* 模块化：nwidart/laravel-modules （用于开发运维自动化的管理页面、以及一些特殊需求业务）
* 监控对接：becker/laravel-zabbix-api
* 微信对接：overtrue/laravel-wechat
* Redis缓存：predis/predis

## 功能（ToDo List） ##
- [x] 任务管理及EAV数据结构
- [x] 通知功能，邮件提醒，产品、项目关联
- [x] 任务状态、类型自定义、任务类型字段自定义
- [x] 业务报表、统计关联查询
- [x] 任务分派及团队任务时间轴查看
- [x] 任务日志管理，日历&时间管理（包括四象限法则、习惯养成、备忘清单）
- [x] 运维自动化管理工具（小模块很多，暂未开源）
- [x] 学习分享，个人档案&目标等
- [ ] 业务库管理，包括：项目库、产品库、客户库、研发项目库、项目意向库、销售订单库、采购库
- [ ] 工作流引擎（实现简化版）
- [ ] OA流程相关的流程模板
- [ ] 微信自动登录、定时消息推送的对接
- [ ] 部分前端、功能模块和语言包改进
- [ ] 整个系统的需求、功能、数据结构、设计、模型等重新梳理规范，用于规划2.0重构系统

## CRUD的相关脚本 ##

```shell

php artisan infyom:scaffold Task --relations
			title string text
			end_at date date
			content text ueditor
			hours integer number
			project_id integer text     	mt1,Project,project_id,id
			user_id integer text			mt1,User,user_id,id
			taskstatus_id integer text	mt1,Taskstatus,taskstatus_id,id
			tasktype_id integer text		mt1,Tasktype,tasktype_id,id

php artisan infyom:scaffold Taskgroup --relations
			task_id integer text            mt1,Task,task_id,id
			user_id integer text			mt1,User,user_id,id

php artisan infyom:scaffold Taskcomment --relations
			task_id integer text            mt1,Task,task_id,id
			grade integer radio,Good:1,Bad:2
			comment text ueditor

php artisan infyom:scaffold Taskstatus --relations
            name string text
            color string color
            user_id integer text            mt1,User,user_id,id

php artisan infyom:scaffold Tasktype --relations
            name string text
            color string color
            assigned_to integer text        mt1,User,assigned_to,id
            user_id integer text            mt1,User,user_id,id

php artisan infyom:scaffold Tasktype_eav --relations
			tasktype_id integer text        mt1,Tasktype,tasktype_id,id
            code string text
            frontend_label string text
            frontend_input string text
            frontend_size integer select,3:25%Width,4:33%Width,6:50%Width,8:66%Width,9:75%Width,12:100%Width
            is_required integer text
            is_unique integer text
            option string text
            user_id integer text            mt1,User,user_id,id
            note string text

php artisan infyom:scaffold Tasktype_eav_value --relations
			task_id integer text            mt1,Task,task_id,id
			task_type_eav_id integer text   mt1,Tasktype_eav,task_id,id
            task_value string text

php artisan infyom:scaffold Userresume --relations
			keyname string text
			content string text
			user_id integer text			mt1,User,user_id,id

php artisan infyom:model Task_tag --relations
			tag_id integer text			    1t1,Tag,tag_id,id
			task_id integer text			1t1,Task,task_id,id
			user_id integer text			mt1,User,user_id,id

php artisan infyom:model Tag --relations
			name string text
			task_id integer text			mtm,Task,task_tag,tag_id,task_id
```