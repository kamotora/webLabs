var express = require('express');
var router = express.Router();
var db = require('../db');
const path = require('path');
var createError = require('http-errors');


const convertResult = (result) => {
  return JSON.parse(JSON.stringify(result));
};

function hasKey(obj, key) {
  return Object.keys(obj).indexOf(key) !== -1
}

const getServicesFromBody = async (body) =>{
  let services = await getServices();
  let result = [];
  for(let i = 0; i < services.length; i++)
    if(hasKey(body,'servicesCheck'+services[i].id))
      result.push(services[i].id);
  return result;
};
const getAutoservice = async (id) => {
  let autoservice = await db.Autoservice.findByPk(id, {
    include: [
      {
        model: db.Service,
        as: 'services',
        required: false,
        through: {attributes: []}
      }
    ]
  });
  return convertResult(autoservice);
};

const getServices = async () => {
  let services = await db.Service.findAll();
  return convertResult(services);
};

// редирект на главную
router.get('/', (req, res, next) => {
  res.redirect('/');
});

// добавление проекта
router.post('/', async (req, res, next) => {
  let autoservice = await db.Autoservice.create(
  {
    name: req.body.name,
    address: req.body.address,
    date_add: req.body.date_add,
    description: req.body.description,
    tel: req.body.tel,
    email: req.body.email,
    photo: req.body.photo
  });
  let checkedServices = await getServicesFromBody(req.body);
  autoservice.setServices(checkedServices);
  res.redirect('/');
});

// страница добавления проекта
router.get('/add', async (req, res, next) => {
  let autoservice = {
    photo: '/assets/no-image.png'
  };
  let services = await getServices();
  if (autoservice) {
    res.render('new', {title: 'Добавление автосервиса', titleButton : 'Добавить', autoservice, services, isEdit: false});
  } else {
    res.json(404);
  }
});

// страница проекта
router.get('/:id', async (req, res, next) => {
  let autoservice = await getAutoservice(req.params.id);
  let services = await getServices();
  let checkedServices = autoservice.services.map(function(service) {
    return service.id;
  });
  if (autoservice) {
    res.render('show', {title: autoservice.name, autoservice,checkedServices,services});
  } else {
    next(createError(404));
  }
});

// обновления проекта
router.post('/:id', async (req, res, next) => {
  await db.Autoservice.update(
        {
          name: req.body.name,
          address: req.body.address,
          date_add: req.body.date_add,
          description: req.body.description,
          tel: req.body.tel,
          email: req.body.email,
          photo: req.body.photo
        },
        {where: {id: req.params.id}}
    );
  let checkedServices = await getServicesFromBody(req.body);
  var autoservice = await db.Autoservice.findByPk(req.params.id);
  await autoservice.setServices(checkedServices);
  res.redirect('/');
});

// страница редактирования проекта
router.get('/edit/:id', async (req, res, next) => {
  let autoservice = await getAutoservice(req.params.id);
  let services = await getServices();
  let checkedServices = autoservice.services.map(function(service) {
    return service.id;
  });

  if (autoservice) {
    res.render('new', {title: 'Изменение '+autoservice.name, titleButton : 'Сохранить', autoservice, checkedServices, services, isEdit: true});
  } else {
    res.json(404);
  }
});

// страница удаления проекта
router.post('/delete/:id', async (req, res, next) => {
  await db.Autoservice.destroy(
      {
        where: {
          id: req.params.id
        }
      });

  res.redirect('/');
});

module.exports = router;