var express = require('express');
var router = express.Router();
var db = require('../db');

const getAutoservices = async () => {
  let autoservices = await db.Autoservice.findAll();
  return autoservices;
};

// главная, список всех проектов
router.get('/', async (req, res, next) => {
  let autoservices = await getAutoservices();
  res.render('index', {title: 'Список автосервисов', autoservices, isAdmin: false});
});

module.exports = router;