## About Project

The purpose of this app is to create Rest APIs to register customer in our system and generate loan installment and collecting payments.
Follwing are the steps to setup the project:

-   Clone the project
-   Install Composer
-   Setup DB in the env
-   Run Migration

    ```
    php artisan migrate
    php artisan passport:install

    ```

Admin user will auto generate when you install the migration.
Username / Password

```
admin@aspire.com/admin@123
```

## Postman Collection

Import [Link](https://www.getpostman.com/collections/dd1ea8e22f0a5cc8dc36)

```
    https://www.getpostman.com/collections/dd1ea8e22f0a5cc8dc36
```

Generate Postman environment with two variables

```
    1. url
    2. token
```

All the API related information is provided into postman collection documentation.

## Some basic info regarding APIS

1. Register as Customer using (Register) API
2. Login as Customer after Registration using (Login)
3. Generate Loan Request Using (Customer - Request Loan)
4. View all the Generated Loan Request using (Customer - Requested Loans)
5. Login as Admin (admin@aspire.com/admin@123)
6. View All Requested Loans (Admin - All Loan Requests)
7. Approve Loan (Admin - Approve Loan Request)
8. Login as Customer again
9. Repay Loan Amount (Customer - Loan Repayment)
