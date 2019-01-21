<?php

namespace Jc91715\Jwt\Console;

use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem;



class JwtCommand extends Command
{

    /**
     * The console command name!
     *
     * @var string
     */
    protected $name = 'make:jwt';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Jwt 后端生成';

    /**
     * The filesystem instance.
     *
     * @var Filesystem
     */
    protected $files;

    public function __construct(Filesystem $files )
    {
        parent::__construct();

        $this->files = $files;

    }

    public function handle()
    {

        $this->makeController();
        $this->makeRoute();
        $this->makeMiddleware();
        $this->makeUserModel();
        $this->info('Jwt Generate Successfully.');


    }


    private function makeController()
    {

        if ($this->files->exists($path = base_path('app/Http/Controllers/AuthController.php'))) {
            return $this->error('app/Http/Controllers/AuthController.php' . ' already exists!');
        }

        $this->files->put($path, $this->compileControllerStub());

    }




    private function makeRoute()
    {
        file_put_contents(
            base_path('routes/api.php'),
            file_get_contents(__DIR__.'/../../stubs/routes.stub'),
            FILE_APPEND
        );
    }

    public function makeMiddleware()
    {
        if ($this->files->exists($path = base_path('app/Http/Middleware/RefreshToken.php'))) {
            return $this->error('app/Http/Middleware/RefreshToken.php' . ' already exists!');
        }

        $this->files->put($path, $this->compileMiddlewareStub());
    }

    public function makeUserModel()
    {
        if ($this->files->exists($path = base_path('app/User.php'))) {
            if ($this->confirm('要删除 app/User.php 吗？删除后会备份一个User.php.old')) {

                if (!$this->files->exists(base_path('app/User.php.old'))) {

                    $old = $this->files->get($path);
                    $this->files->put( base_path('app').'/User.php.old', $old);
                    $this->info('app/User.php.old 备份成功');
                }
                $this->files->delete($path);

                $this->files->put($path, $this->compileUserModelStub());


            }
        }


    }
    public function compileControllerStub()
    {
        $stub = $this->files->get(__DIR__.'/../../stubs/AuthController.stub');

        return $stub;
    }

    public function compileMiddlewareStub()
    {
        $stub = $this->files->get(__DIR__.'/../../stubs/RefreshToken.stub');

        return $stub;
    }


    public function compileUserModelStub()
    {
        $stub = $this->files->get(__DIR__.'/../../stubs/User.stub');

        return $stub;
    }

    /**
     * Build the directory for the class if necessary.
     *
     * @param  string $path
     * @return string
     */
    protected function makeDirectory($path)
    {
        if (!$this->files->isDirectory(dirname($path))) {
            $this->files->makeDirectory(dirname($path), 0777, true, true);
        }
    }


}
