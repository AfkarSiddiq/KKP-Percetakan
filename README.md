<br>
<p align="center"><img src="public/assets/img/logo.png" alt="E-Hospital Logo" width="300"></p>
<br>
## About Printing Management System
<p>Welcome to the Printing Management System, your all-in-one solution for efficient and seamless management of digital printing operations. Designed exclusively for printing shops, our system streamlines the entire printing process, from order intake to final delivery. With an intuitive interface, the Digital Printing Shop Management System empowers you to effortlessly handle print orders, track materials, manage tasks, and oversee projects. Whether you're catering to a diverse clientele or managing intricate printing projects, our user-friendly platform equips you with the tools needed to enhance productivity and provide top-notch services.</p>

## Installation

##### 1. Clone the repository

```bash
git clone https://github.com/AfkarSiddiq/KKP-Percetakan.git
```

<br>

##### 2. Go to folder and run

```bash
composer update
```

```bash
composer install
```

<br>

##### 3. migrate the table

Copy the contents of `.env.example` file to new `.env` file:

```sh
cp .env.example .env
```

Create an application encryption key:

```sh
php artisan key:generate
```

Create an empty database and fill in the `DB_HOST`, `DB_PORT`, `DB_DATABASE`, `DB_USERNAME` and `DB_PASSWORD` fields in the `.env` file to match the credentials of your newly created database.

Run the migrations:

```sh
php artisan migrate --seed
```

<br>

##### 4. Run serve

 <p>run serve with</p>

```bash
php artisan serve
```

## Contact info

if any problem u can contact us on whatsapp or email:

```bash
frisrsyd@gmail.com
```

```bash
https://api.whatsapp.com/send?phone=6285261297134
```
