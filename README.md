# tophp-framework

[![Build Status](https://travis-ci.org/joemccann/dillinger.svg?branch=master)](https://github.com/sobirjonovs/tophp-framework) TOPHP - the most popular php framework :)

# Install all packages
```sh
composer install
```
# Start local web server
```sh
php do server
```
# Write custom routes (project_folder/routes/web.php)
```sh
<?php

use App\Controllers\HomeController;

$route->get('/', [HomeController::class, 'index']);

// Routing with wildcards
$route->get('user/{id}', function($id) {
    echo $id;
});

$route->get('users/create', [HomeController::class, 'create']);
$route->post('users', [HomeController::class, 'store']);
```

# Available database accessor (model) methods
| Method | Description |
| ------ | ------ |
| create(array $data) | Inserts the values into database |
| all() | Gets whole data from the table |
| where(array $condition) | Gets data conditionally from table |
| other methods: find(), update(), get() and etc... | Not completed |

# Defining custom table
- If you don't define $table property, framework uses the model's plural name as table name
```sh
<?php

namespace App\Models;

class User extends Model
{
    // protected $table = 'customers'; 
}
```
# Getting a data from table via model
```sh
<?php

namespace App\Controllers;

use App\Models\User;
use Bootstrap\Requests\Helpers\Filter;
use Bootstrap\Requests\Helpers\FilterTrait;
use Bootstrap\Requests\Request;
use Core\Session\Session;
use Core\Session\SessionFlash;
use Exception;
use GuzzleHttp\Client;

class HomeController extends Controller
{
    /**
     * @return mixed
     */
    public function index()
    {
        return view('welcome');
    }

    public function create()
    {
        return view('user/create');
    }

    public function store(Request $request)
    {
        $validated = Filter::validate([
            'email' => 'email',
            'phone' => 'integer'
        ]);

        echo "validated page";
    }
}

```
# Defining a layout for the view
- If you don't define a layout for the view, the framework uses default layout (resources/layouts/app.php)
```sh
<?php

namespace App\Controllers;

use App\Models\User;
use Exception;

class HomeController extends Controller
{
    /**
     * @return mixed
     */
    public function index()
    {
        return view('welcome', [], 'layoutname');
    }
}

```
