# Setup instructions
1. Install Symfony CLI from: https://symfony.com/download
2. Clone the repository:
```
git clone git@github.com:e717f481-ff99-4acf-a984-8cdd2a0e7022/orders_exercise.git orders_exercise
```
2. Install project dependencies with composer 
```
composer install
```
3. Create DB (we use sqlite for this project)
```
bin/console doctrine:database:create
```
4. Run Doctrine migrations
```
bin/console doctrine:migrations:migrate
```
5. Start the server
```
symfony server:start
```

# Business flows
The project has 2 pages:
1. Index page 
    - which contains a list of all the orders
2. Show page
    - with all the details of an order
    - allows the update of order status

# Requirements
1. Check the entities and find potential issues or improvements with the code in `src\Entity\`
2. Improve the code in the `OrdersController` class, which can be found in `src\Controller\`, to better match the routes, and the current business flows
3. Add a new page in which orders can be created. For orders, we need the following fields:
      - `status`: will always have the value `created` for new orders
      - `recipientName`
      - `address`
      - `number`

### Notes:
- Routes can be configured in `config\routes.yaml`
- Twig files with which templates should be created in `templates\app\order`