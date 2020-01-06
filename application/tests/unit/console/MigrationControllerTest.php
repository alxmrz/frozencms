<?php


use console\controller\MigrationController;
use core\exceptions\MigrationNameNotProvidedException;

class MigrationControllerTest extends CustomTestCase
{
    public function testCreate_WhenActionIsCalledThenMigrationFileIsCreated()
    {
        $migrationController = $this->createMigrationController();
        $migrationController->actionCreate('fileName');

        $this->assertStringMatchesFormat('m%d_fileName.php', $migrationController->migrationName);
    }

    public function testCreate_WhenMigrationNameIsNotSetOrEmptyThenThrowException()
    {
        $migrationController = $this->createMigrationController();
        $this->expectException(MigrationNameNotProvidedException::class);

        $migrationController->actionCreate('');
    }

    public function testCreate_WhenMethodCalledThenCreateMigrationFileTemplateWillBeUsed()
    {
        $migrationController = $this->createMigrationController();
        $migrationController->actionCreate('create_migration_table');

        $this->assertStringMatchesFormat('class m%d_create_migration_table', $migrationController->migrationFileContent);
    }

    protected function createMigrationController()
    {
        return new class() extends MigrationController {
            public $migrationName;
            public $migrationFileContent;

            public function createMigrationFile(string $fileName, $content)
            {
                $this->migrationName = $fileName;
                $this->migrationFileContent = $content;
            }

            public function getTemplateContent()
            {
                return 'class MigrationClassTemplate';
            }
        };
    }
}