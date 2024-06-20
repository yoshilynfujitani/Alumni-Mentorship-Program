# Setup and Installation

## Set Up .env configuration

### Get your MAIL Configs from MAILGUN.COM

Step 1: Create an Account with Mailgun
Step 2: Once on Dashboard click on `Send` then proceed to `Sending`, finally click `Overview`
Step 3: Select `SMTP` and copy given credentials to your .env file

The Following should be filled:

```
MAIL_HOST = SMTP Hostname
MAIL_PORT = Port
MAIL_USERNAME = Username
MAIL_PASSWORD = Default Password

MAILGUN_DOMAIN = Domain Name -> Copy MAIL_USERNAME and remove `postmaster@`
MAILGUN_SECRET = Domain Secret / API Key -> Create your own Api Key
```

Set the following to:

```
MAIL_ENCRYPTION=ssl

> Make sure all email adresses are authorized recipients
MAIL_FROM_ADDRESS= `Email to be used for sending emails`
```

### Get your PUSHER Configs from PUSHER.COM

Step 1: Create an Account with Pusher
Step 2: Get started with Channels, Set Preferred name and Set cluster to ap1
Step 3: Navigate to API Keys

The Following should be filled:

```
PUSHER_APP_ID = app_id
PUSHER_APP_KEY= key
PUSHER_APP_SECRET= secret
PUSHER_APP_CLUSTER = ap1
```

## Install Dependencies

```
npm install

composer install

```

## Setup Databases

Create 3 Different Databases:

```
studentportal
mentorportal
adminportal


```

## Migrate Tables and Seeders

```
php artisan migrate

php artisan db:seed -> Wait for UserSeeder to finish

```

## Login

```
All the accounts' password is '12345678'

Admin Credentials
Email: yoshi@admin.com
Password: '12345678'
```
