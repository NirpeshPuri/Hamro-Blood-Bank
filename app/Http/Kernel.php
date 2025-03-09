protected $routeMiddleware = [
// Other middleware
'admin' => \App\Http\Middleware\AdminMiddleware::class,
'receiver' => \App\Http\Middleware\ReceiverMiddleware::class,
'donor' => \App\Http\Middleware\DonorMiddleware::class,
];
