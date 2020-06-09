## Web Parsing 
Write a website parser which will parse the given website and collect all the company related
information and store it in a database. You need to collect maximum information of company
like CIN, industry, class AND ALL THE FIELDS WHICH IS available on this website. You
have to write an API as well to parse the data from the website. Using parsing techniques,
you can write an API and store it in the DB.
Website link :http://www.mycorporateinfo.com/

Eq: Company URL:http://www.mycorporateinfo.com/business/kamdhenu-
engineering-industries-ltd

Few more useful urls:
http://www.mycorporateinfo.com/industry
http://www.mycorporateinfo.com/industry/section/F
http://www.mycorporateinfo.com/business/shilpi-builders-limited-1
Design a DB schema and insert all the company information in the tables.
Code should be generic and should be able to parse all the details of the companies.
You can use the laravel framework also.


### Steps to run project:

#### Step 1:  After downloading repository run following commands.
>composer install

Update .env file with database credentials
#### Step 2: Run migration commands to create tables :
> php artisan migrate

#### Step 3: Run following command to parse data from websites.
> php artisan web:parsing

To parse companies information for a particular industry, run following command.
> php artisan web:parsing --industry_id=1

industry_id is the primary key of industries table

This command will parse the data from website and store in DB

###### Note : No of pages for parsing can be changed in app/Scrapping/Parsing.php.


