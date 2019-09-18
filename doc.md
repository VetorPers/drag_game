### 登录(post)
> http://118.24.70.62:8080/pest/login

param:

* {"type":1} 游客登录
* {"type":2,"number":"123"} 学号登录
* 管理员登录跳链接 /admin

返回：

{
            'result'    => true,
            'user_id'   => 1,
            'tree_sign' => 1, // 1桃子树  2李子树
}


### 获取问题（get）
> http://118.24.70.62:8080/pest/questions

param:
{"user_id":1}

返回：试试看


### 保存答题(post)
> http://118.24.70.62:8080/pest/storeUserAnswer

param:

{
"user_id":1,
"data":[
{"question_id":1,"answer_ids":[1]},
{"question_id":2,"answer_ids":[1,2]}
]
}

返回：is_pass true通过 false未通过
