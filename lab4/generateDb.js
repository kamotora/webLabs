var Service = require('./db').Service;
var Autoservice = require('./db').Autoservice;

var services = ['Шиномонтаж', 'Плановое ТО','Замена жидкостей','Кузовной ремонт', 'Ремонт подвески', 'Ремонт двигателя', 'Диагностика'];
var autoservices = [
    {
        name: 'DDCAR',
        address: 'улица Ленина, 235',
        description:'Автосервис «DDCAR» предлагает качественный ремонт автомобилей в Москве по приемлемым ценам. Мы профессионально ремонтируем автомобили европейских марок любых лет выпуска уже далеко не первый год.\n' +
            'Для многих вадельцев автомобилей наш автосервис является одним из немногих, где можно устранить практически любую неисправность. Благодаря многолетнему опыту и профессиональному обучению наши специалисты справятся с любой поставленной задачей по ремонту автомобиля.',
        date_add: '2020-02-04',
        email: 'test@test.com',
        tel: '+7 (924) 111-33-51',
        photo: '/assets/services/ddcar.jpg',
        services: [1, 2]
    },
    {
        name: 'Check Engine',
        address: 'Боровский проезд, 17с4  ',
        description:'Рассчитаем стоимость, подберем и купим запчасти, запишем на удобное время.\n' +
            'Предлагаем всегда честные и адекватные цены.\n' +
            'С заботой о Вашем авто.\n' +
            'Приезжайте и убедитесь сами!',
        date_add: '2020-02-04',
        tel: '+7 (914) 385-31-11',
        photo: '/assets/services/check_engine.jpeg',
        services: [3, 4]
    }
];

services.map(service => {
    Service.create({
        name: service
    }).then(res => {
        console.log(res);
    }).catch(err => console.log(err));
});

autoservices.map(autoservice => {
    Autoservice.create(autoservice).then(_autoservice => {
        _autoservice.setServices(autoservice.services);
    }).catch(err => console.log(err));
});