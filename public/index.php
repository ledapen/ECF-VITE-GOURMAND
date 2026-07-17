<?php
declare(strict_types=1);

session_start();

require_once __DIR__ . '/../app/core/Database.php';
require_once __DIR__ . '/../app/core/Controller.php';
require_once __DIR__ . '/../app/core/Router.php';
require_once __DIR__ . '/../app/core/Security.php';

spl_autoload_register(function ($class) {
    $paths = [
        __DIR__ . '/../app/controllers/' . $class . '.php',
        __DIR__ . '/../app/models/' . $class . '.php',
        __DIR__ . '/../app/services/' . $class . '.php',
        __DIR__ . '/../app/core/' . $class . '.php',
    ];

    foreach ($paths as $path) {
        if (file_exists($path)) {
            require_once $path;
            return;
        }
    }
});

$router = new Router();

$router->get('/', [HomeController::class, 'index']);
$router->get('/menus', [MenuController::class, 'index']);
$router->get('/menu', [MenuController::class, 'show']);
$router->get('/login', [AuthController::class, 'loginForm']);
$router->post('/login', [AuthController::class, 'login']);
$router->get('/register', [AuthController::class, 'registerForm']);
$router->post('/register', [AuthController::class, 'register']);
$router->get('/logout', [AuthController::class, 'logout']);
$router->get('/contact', [ContactController::class, 'form']);
$router->post('/contact', [ContactController::class, 'send']);
$router->get('/orders/create', [OrderController::class, 'create']);
$router->post('/orders/store', [OrderController::class, 'store']);


$router->get('/user/orders', [UserController::class, 'orders']);
$router->get('/employee/dashboard', [EmployeeController::class, 'dashboard']);
$router->get('/employee/menus', [EmployeeController::class, 'menus']);
$router->get('/employee/menu-create', [EmployeeController::class, 'createMenu']);
$router->post('/employee/menu-store', [EmployeeController::class, 'storeMenu']);
$router->get('/employee/orders', [EmployeeController::class, 'orders']);
$router->post('/employee/order-status', [EmployeeController::class, 'updateOrderStatus']);
$router->get('/admin/dashboard', [AdminController::class, 'dashboard']);
$router->get('/admin/employees', [AdminController::class, 'employees']);
$router->post('/admin/employees/store', [AdminController::class, 'storeEmployee']);
$router->post('/admin/employees/toggle', [AdminController::class, 'toggleEmployee']);
$router->get('/api/menus', [ApiController::class, 'menus']);

$router->get('/password/forgot', [PasswordController::class, 'forgotForm']);
$router->post('/password/forgot', [PasswordController::class, 'sendLink']);
$router->get('/password/reset', [PasswordController::class, 'resetForm']);
$router->post('/password/reset', [PasswordController::class, 'reset']);

$router->get('/employee/menu-edit', [EmployeeController::class, 'editMenu']);
$router->post('/employee/menu-update', [EmployeeController::class, 'updateMenu']);
$router->post('/employee/menu-delete', [EmployeeController::class, 'deleteMenu']);
$router->get('/employee/plates', [PlateController::class, 'index']);
$router->post('/employee/plates/store', [PlateController::class, 'store']);
$router->post('/employee/plates/delete', [PlateController::class, 'delete']);
$router->get('/employee/hours', [HoursController::class, 'index']);
$router->post('/employee/hours/update', [HoursController::class, 'update']);
$router->get('/employee/contacts', [EmployeeController::class, 'contacts']);
$router->post('/employee/contact-treated', [EmployeeController::class, 'markContactTreated']);

$router->post('/user/order-cancel', [UserController::class, 'cancelOrder']);
$router->get('/user/profile', [UserController::class, 'profile']);
$router->post('/user/profile-update', [UserController::class, 'updateProfile']);

$router->get('/admin/stats.json', [AdminController::class, 'statsJson']);

$router->post('/user/review', [ReviewController::class, 'store']);
$router->get('/employee/reviews', [EmployeeController::class, 'reviews']);
$router->post('/employee/review-validate', [EmployeeController::class, 'validateReview']);


$router->dispatch($_SERVER['REQUEST_METHOD'], $_SERVER['REQUEST_URI']);
