<?php
namespace Nocarrier\Build;

class BuilderTest extends \PHPUnit_Framework_TestCase
{
    const TMP = '/tmp/builderTestRoot';

    public function setUp()
    {
        mkdir(self::TMP);
    }

    protected function rrmdir($dir)
    {
        foreach(glob($dir . '/*') as $file) {
            if(is_dir($file))
                $this->rrmdir($file);
            else
                unlink($file);
        }
        rmdir($dir);
    }

    public function tearDown()
    {
        $this->rrmdir(self::TMP);
    }

    private function createDirectory($name)
    {
        $should = new Controller();
        $should->create->directory->named($name)->in(self::TMP);
        $should->go();
        $this->assertFileExists(self::TMP . "/$name");
    }

    function testCreateDirectory()
    {
        $this->createDirectory('testdir');
    }

    function testCreateDirectoryWhenDirectoryExists()
    {
        $this->createDirectory('testdir');
        $this->createDirectory('testdir');
    }

    function testDeleteDirectory()
    {
        $this->assertTrue(mkdir(self::TMP . '/testdir'));
        $should = new Controller();
        $should->delete->directory->named('testdir')->in(self::TMP);
        $should->go();

        $this->assertFileNotExists(self::TMP . '/testdir');
    }

    /**
     * @expectedException Nocarrier\Build\PhpUnitException
     **/
    function testRunPhpUnitExpectFail()
    {
        $should = new Controller();
        $should->run()->phpunit()->in(self::TMP);
        $should->go();
    }

    function testRunPhpLinterWithValidFile()
    {
        $code = <<<'EOF'
<?php

$a = 1+1;
echo $a;
EOF;
        file_put_contents(self::TMP . '/test.php', $code);
        $should = new Controller();
        $should->run->phplint->in(self::TMP);
        $should->go();
    }

    /**
     * @expectedException Nocarrier\Build\PhpLintException
     **/
    function testRunPhpLinterWithInvalidFile()
    {
        $code = <<<'EOF'
<?php

$a 1+1;
echo $a;
EOF;
        file_put_contents(self::TMP . '/test.php', $code);
        $should = new Controller();
        $should->run->phplint->in(self::TMP);
        $should->go();
    }
}
