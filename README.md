# dcat-admin extension

[Distpicker](https://github.com/fengyuanchen/distpicker)是一个中国省市区三级联动选择组件，这个包是基于`Distpicker`的`dcat-admin`扩展，用来将`Distpicker`集成进`dcat-admin`的表单中.

此扩展参考与引用：

- [dcat-admin-extensions-distpicker](https://github.com/super-eggs/dcat-admin-extensions-distpicker)

- [laravel-admin-extensions](https://github.com/laravel-admin-extensions)

- [china-distpicker](https://github.com/laravel-admin-extensions/china-distpicker)

- [distpicker](https://github.com/fengyuanchen/distpicker)

- [spakinzy/distpicker](https://github.com/Sparkinzy/distpicker) ：个人定制版distpicker,方便个人使用,[dcat-distpicker](https://github.com/Sparkinzy/dcat-distpicker) 使用此库[spakinzy/distpicker](https://github.com/Sparkinzy/distpicker)
   
 

## 截图

1、安装

```composer require sparkinzy/dcat-distpicker```

2、Dcat 后台发布资源

![install](https://tva1.sinaimg.cn/large/008i3skNgy1gq1qgdqsf8g30nc0bkdsp.gif)

3、dcat-distpicker 使用方式

![code](https://tva1.sinaimg.cn/large/008i3skNgy1gq1qi98gpdj30860860t6.jpg)

4、呈现效果

![image-usage](https://tva1.sinaimg.cn/large/008i3skNgy1gq1q6t3waxj30hx0a2aaf.jpg)

 

### 表单中使用

比如在表中有三个字段`province_name`, `city_name`, `district_name`, 在form表单中使用它：

```
$form->distpicker(['province_name', 'city_name', 'district_name']);
```

设置默认值

```
$form->distpicker([
    'province_name' => '省份',
    'city_name' => '市',
    'district_name' => '区'
], '地域选择')->default([
    'province' => '黑龙江省',
    'city'     => '双鸭山市',
    'district' => '四方台区',
])->select2();
```

设置返回值类型

默认 name,可修改返回类型为code,但目前不推荐

```

$form->distpicker([
    'province_name' => '省份',
    'city_name' => '市',
    'district_name' => '区'
], '地域选择')->type('code');

```

可以设置每个字段的placeholder

```
$form->distpicker([
    'province_name' => '省',
    'city_name'     => '市',
    'district_name' => '区'
]);
```

设置label

```
$form->distpicker(['province_name', 'city_name', 'district_name'], '请选择区域');
```

设置自动选择, 可以设置1,2,3 表示自动选择到第几级

```
$form->distpicker(['province_name', 'city_name', 'district_name'])->autoselect(1);
```

启用select2进行渲染

```
$form->distpicker(['province_name', 'city_name', 'district_name']))->select2();
```

### 表格筛选中使用

```
# province_name 为字段名
$filter->distpicker(['province_name', 'city_name', 'district_name'], '地域选择');

```

## 地区编码数据

[Distpicker](https://github.com/fengyuanchen/distpicker)所使用的地域编码是基于国家统计局发布的数据, 数据字典为`china_area.sql`文件.

## Todo 

- [x] 可以自定义是否返回code或者name 
- [x] Grid filter扩展
