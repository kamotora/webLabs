const Sequelize = require("sequelize");

const sequelize = new Sequelize('mysql://root:@localhost:3306/lab4_autorepair', {});
sequelize
    .authenticate()
    .then(() => {
        console.log('Соединение установлено.');
    })
    .catch(err => {
        console.error('Ошибка соединения:', err);
    });

const Autoservice = sequelize.define("autoservices", {
    id: {
        type: Sequelize.INTEGER,
        autoIncrement: true,
        primaryKey: true,
        allowNull: false
    },
    address: {
        type: Sequelize.STRING(1024),
        allowNull: false
    },
    date_add: {
        type: Sequelize.DATEONLY,
        allowNull: false,
        set(value) {
            if(value == null || this.getDataValue('date_add') == null){
                this.setDataValue('date_add', new Date());
            }
        }
    },
    description: {
        type: Sequelize.STRING(2048),
        allowNull: true,

    },
    email: {
        type: Sequelize.STRING,
        allowNull: true
    },
    tel: {
        type: Sequelize.STRING,
        allowNull: false
    },
    name: {
        type: Sequelize.STRING,
        allowNull: true
    },
    photo: {
        type: Sequelize.STRING(1024),
        allowNull: true,
        get(){
            const NO_IMAGE_PATH = '/assets/no-image.png';
            const START_PHOTO_PATH = '/assets/services/';
            let photo = this.getDataValue('photo');
            if(photo == null || photo === '' || photo === START_PHOTO_PATH)
                return NO_IMAGE_PATH;
            return photo;
        },
        set(value){
            const START_PHOTO_PATH = '/assets/services/';

            if(value != null && value !== '' && value !== START_PHOTO_PATH){
                value = START_PHOTO_PATH + value;
                this.setDataValue('photo', value);
            }
        }
    }
});

const Service = sequelize.define("services", {
    id: {
        type: Sequelize.INTEGER,
        autoIncrement: true,
        primaryKey: true,
        allowNull: false
    },
    name: {
        type: Sequelize.STRING,
        allowNull: false
    }
});


const Autoservice_Service = sequelize.define('autoservice_service', {});
Autoservice.belongsToMany(Service, { through: Autoservice_Service });
Service.belongsToMany(Autoservice, { through: Autoservice_Service });
/*
sequelize.sync({force: true}).then(result => {
    console.log(result);
    var generateDb = require('./generateDb');
}).catch(err => console.log(err));
*/
module.exports.db = sequelize;
module.exports.Autoservice = Autoservice;
module.exports.Service = Service;
module.exports.Autoservice_Service = Autoservice_Service;