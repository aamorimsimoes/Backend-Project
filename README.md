# Company App 
# Final backend project for Fullstack Web Delevoper Course

An App the with four basic functions of persistent storage CRUD* previously designed with an entity relationship diagram.
The application will allow the user to register and validate it (receiving an email with [PHPMailer](https://github.com/PHPMailer/PHPMailer)(this is a simple validation step to complete the registration process where the user must enter a valid email address which they have access) and login in the reserved area by adding and editing information (news & products) accessible to the community / company.
Users will be separated into two levels with different levels of access and permissions:
### Admin: 
This permission level allows access to two additional sections: users dashboard and generator. 
- **Users dashboard** will allow you to manage access levels, if the user is active or blocked and export data generating a PDF with active users using [FPDF](http://www.fpdf.org/);
- **Generator** will allow you to feed a field like news, products and users using [Faker](https://github.com/fzaninotto/Faker);

set news and products state (draft, archived, draw or published) Through the dashboard, the admin can add and configure numbers and users. The dashboard also allows access to call analytics, billing information, and other features.
### User: 
This permission level allows access to the Aircall app but does not allow access to the Dashboard. The user can make and receive calls from the app and define personal preferences. However, user-level permissions cannot modify number settings or preferences from an overall account level.
___
- *FAKER - PHP library that generates fake data by [Francois Zaninotto](https://github.com/fzaninotto)*; 
- *[PHP]()*
- *[PHPMailer]()*






---
# develop tools
- using tailwind css, browser sync
- Database and diagram ERR has been developed with MySQLWorkbench 

# run:
- npm i
- composer i


Comments have been done with: Comment Anchors

The default settings come with anchors for the following tags:

- ANCHOR- Used to indicate a section in your file
- TODO- An item that is awaiting completion
- FIXME- An item that requires a bugfix
- STUB- Used for generated default snippets
- NOTE- An important note for a specific code section
- REVIEW- An item that needs additional review
- SECTION- Used to define a region (See 'Hierarchical anchors')
