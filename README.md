# Company App 
# Final backend project for Fullstack Web Delevoper Course

An App with four basic functions of persistent storage CRUD* previously designed with an entity relationship diagram [MySQL Database](https://www.mysql.com/).
The application will allow the user to register, receiving an email sended by [PHPMailer](https://github.com/PHPMailer/PHPMailer) and validating it. Login in the reserved area, adding and editing information accessible to the community / company.

Registered users are separated with different levels of access and permissions:

##### User: 
This permission level allows access to basic functionalities such as adding and editing news and products which are also available at the home page for detailed reading and edit profile info;
All information submitted by the user has the status "review" for later validation by the admin and publication on the home page;

##### Admin: 
This permission level allows access to two additional sections: users dashboard and generator. 
- **Users dashboard** allows you to manage access levels, if the user is active or blocked and export data generating a PDF with active users using [FPDF](http://www.fpdf.org/) library;
- **Generator** allows you to feed a field like news, products and users using [Faker](https://github.com/fzaninotto/Faker) library for the purpose of testing;

Also allows you to change news and products state (draft, archived, review or published) and manage the status of those users as active or blocked and permission level, admin or user; 
___
# Installation / Usage

1. Clone the repository: git clone https://github.com/aamorimsimoes/backendProject.git
2. Install [npm](https://www.npmjs.com/) dependencies:

```bash
$ npm install
```
3. Install [composer](https://getcomposer.org/) dependencies:
```bash
$ composer i
```
4. Run [Gulp](https://gulpjs.com/) (since the [browsersync](https://www.browsersync.io/) is integrated with task runner Gulp it is possible to create a personalised test environment)
```bash
$ gulp
```

5. Login

Admin 
Email: admin@company.com 
Password: 12345
Default User 
Email: user@company.com 
Password: 12345

6. Enjoy it!


