<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Auth::routes();

Route::get('/', 'HomeController@index')->name('home')->middleware('auth');

Route::get('inventory/product/table/{id}', 'ProductController@tableProducts');


Route::get('inventory/production/producir/{production}', 'ProductionController@producir')->name('production.producir');
Route::post('inventory/production/producir/{production}/make', 'ProductionController@make')->name('production.make');

Route::get('inventory/production/inproducir/{production}', 'ProductionController@inproducir')->name('production.inProducir');
Route::post('inventory/production/producir/{production}/inmake', 'ProductionController@inmake')->name('production.inMake');

Route::group(['middleware' => 'auth'], function () {


    Route::any('inventory/search', 'InventoryController@search')->name('inventory.inventory.search');
    Route::resource('inventory/inventory', 'InventoryController')->names('inventory.inventory');



    Route::get('/changeSucursal/{id}', 'BranchController@changeSucursal')->name('branch.change');
    Route::resources([
        'branches' => 'BranchController',
        'users' => 'UserController',
        'providers' => 'ProviderController',
        'inventory/products' => 'ProductController',
        'inventory/materials' => 'MaterialController',
        'inventory/production' => 'ProductionController',
        'inventory/spendingProfiles' => 'SpendingProfileController',

        'clients' => 'ClientController',
        'inventory/categories' => 'ProductCategoryController',
        'transactions/transfer' => 'TransferController',
        'methods' => 'MethodController',
        'rrhh/employees' => 'EmployeeController',
        'rrhh/salary' => 'SalaryController'

    ]);

    Route::resource('transactions', 'TransactionController')->except(['create', 'show']);
    Route::get('transactions/stats/{year?}/{month?}/{day?}', ['as' => 'transactions.stats', 'uses' => 'TransactionController@stats']);
    Route::get('transactions/{type}', ['as' => 'transactions.type', 'uses' => 'TransactionController@type']);
    Route::get('transactions/{type}/create', ['as' => 'transactions.create', 'uses' => 'TransactionController@create']);
    Route::get('transactions/{transaction}/edit', ['as' => 'transactions.edit', 'uses' => 'TransactionController@edit']);

    Route::get('inventory/stats/{year?}/{month?}/{day?}', ['as' => 'inventory.stats', 'uses' => 'InventoryController@stats']);
    Route::resource('inventory/receipts', 'ReceiptController')->except(['edit', 'update']);
    Route::get('inventory/receipts/{receipt}/finalize', ['as' => 'receipts.finalize', 'uses' => 'ReceiptController@finalize']);
    Route::get('inventory/receipts/{receipt}/product/add', ['as' => 'receipts.product.add', 'uses' => 'ReceiptController@addproduct']);
    Route::get('inventory/receipts/{receipt}/product/{receivedproduct}/edit', ['as' => 'receipts.product.edit', 'uses' => 'ReceiptController@editproduct']);
    Route::post('inventory/receipts/{receipt}/product', ['as' => 'receipts.product.store', 'uses' => 'ReceiptController@storeproduct']);
    Route::match(['put', 'patch'], 'inventory/receipts/{receipt}/product/{receivedproduct}', ['as' => 'receipts.product.update', 'uses' => 'ReceiptController@updateproduct']);
    Route::delete('inventory/receipts/{receipt}/product/{receivedproduct}', ['as' => 'receipts.product.destroy', 'uses' => 'ReceiptController@destroyproduct']);



    Route::get('inventory/receipts/{receipt}/transaction/add', ['as' => 'inventory.receipts.transaction.add', 'uses' => 'ReceiptController@addtransaction']);
    Route::get('inventory/receipts/{receipt}/transaction/{transaction}/edit', ['as' => 'inventory.receipts.transaction.edit', 'uses' => 'ReceiptController@edittransaction']);
    Route::post('inventory/receipts/{receipt}/transaction', ['as' => 'inventory.receipts.transaction.store', 'uses' => 'ReceiptController@storetransaction']);
    Route::match(['put', 'patch'], 'inventory/receipts/{receipt}/transaction/{transaction}', ['as' => 'inventory.receipts.transaction.update', 'uses' => 'ReceiptController@updatetransaction']);
    Route::delete('inventory/receipts/{receipt}/transaction/{transaction}', ['as' => 'inventory.receipts.transaction.destroy', 'uses' => 'ReceiptController@destroytransaction']);

    Route::get('sales/orders/api', 'Api\SaleApiController@getOrders');

    Route::get('sales/orders/prepared/{sale}', ['as' => 'sales.orders.prepared', 'uses' => 'SaleController@orderPrepared']);
    Route::get('sales/orders/prepare/{sale}', ['as' => 'sales.orders.prepare', 'uses' => 'SaleController@orderPrepare']);
    Route::get('sales/orders', ['as' => 'sales.orders.index', 'uses' => 'SaleController@orderIndex']);

    Route::get('sales/{sale}/print-receipt', ['as' => 'sales.print-receipt', 'uses' => 'SaleController@printReceipt']);

    Route::resource('sales', 'SaleController')->except(['edit', 'update']);
    Route::get('sales/{sale}/finalize', ['as' => 'sales.finalize', 'uses' => 'SaleController@finalize']);
    Route::get('sales/{sale}/product/add', ['as' => 'sales.product.add', 'uses' => 'SaleController@addproduct']);
    Route::get('sales/{sale}/product/{soldproduct}/edit', ['as' => 'sales.product.edit', 'uses' => 'SaleController@editproduct']);
    Route::post('sales/{sale}/product', ['as' => 'sales.product.store', 'uses' => 'SaleController@storeproduct']);
    Route::match(['put', 'patch'], 'sales/{sale}/product/{soldproduct}', ['as' => 'sales.product.update', 'uses' => 'SaleController@updateproduct']);
    Route::delete('sales/{sale}/product/{soldproduct}', ['as' => 'sales.product.destroy', 'uses' => 'SaleController@destroyproduct']);


    Route::get('sales/{sale}/transaction/add', ['as' => 'sales.transaction.add', 'uses' => 'SaleController@addtransaction']);
    Route::get('sales/{sale}/transaction/{transaction}/edit', ['as' => 'sales.transaction.edit', 'uses' => 'SaleController@edittransaction']);
    Route::post('sales/{sale}/transaction', ['as' => 'sales.transaction.store', 'uses' => 'SaleController@storetransaction']);
    Route::match(['put', 'patch'], 'sales/{sale}/transaction/{transaction}', ['as' => 'sales.transaction.update', 'uses' => 'SaleController@updatetransaction']);
    Route::delete('sales/{sale}/transaction/{transaction}', ['as' => 'sales.transaction.destroy', 'uses' => 'SaleController@destroytransaction']);


    Route::get('clients/{client}/transactions/add', ['as' => 'clients.transactions.add', 'uses' => 'ClientController@addtransaction']);

    Route::get('profile', ['as' => 'profile.edit', 'uses' => 'ProfileController@edit']);
    Route::match(['put', 'patch'], 'profile', ['as' => 'profile.update', 'uses' => 'ProfileController@update']);
    Route::match(['put', 'patch'], 'profile/password', ['as' => 'profile.password', 'uses' => 'ProfileController@password']);
});

Route::group(['middleware' => 'auth'], function () {
    Route::get('icons', ['as' => 'pages.icons', 'uses' => 'PageController@icons']);
    Route::get('notifications', ['as' => 'pages.notifications', 'uses' => 'PageController@notifications']);
    Route::get('tables', ['as' => 'pages.tables', 'uses' => 'PageController@tables']);
    Route::get('typography', ['as' => 'pages.typography', 'uses' => 'PageController@typography']);
});
