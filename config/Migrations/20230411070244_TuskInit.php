<?php
declare(strict_types=1);

use Migrations\AbstractMigration;

class TuskInit extends AbstractMigration
{
    /**
     * Change Method.
     *
     * More information on this method is available here:
     * https://book.cakephp.org/phinx/0/en/migrations.html#the-change-method
     * @return void
     */
    public function change(): void {
		$userTable = 'tusk_users';
		$layoutsTable = 'tusk_layouts';
		$elementsTable = 'tusk_elements';
		$contentsTable = 'tusk_contents';
		$pagesTable = 'tusk_pages';

		$this->table($userTable)
			->addColumn('name', 'string', [
				'default' => null,
				'limit' => 100,
				'null' => false,
			])
			->addColumn('email', 'string', [
				'default' => null,
				'limit' => 100,
				'null' => false,
			])
			->addColumn('password', 'string', [
				'default' => null,
				'null' => false,
			])
			->addColumn('active', 'boolean', [
				'default' => 1,
			])
			->addColumn('created', 'timestamp', [
				'default' => 'CURRENT_TIMESTAMP'
			])
			->addColumn('modified', 'timestamp', [
				'default' => 'CURRENT_TIMESTAMP',
				'update' => 'CURRENT_TIMESTAMP'
			])
			->create();

		$this->table('tusk_apps')
			->addColumn('name', 'string', [
				'default' => null,
				'limit' => 100,
				'null' => false,
			])
			->addColumn('alias', 'string', [
				'default' => null,
				'limit' => 100,
				'null' => false,
			])
			->addColumn('active', 'boolean', [
				'default' => 1,
			])
			->addColumn('tusk_group_id', 'integer', [
				'null' => true
			])
			->addColumn('created', 'timestamp', [
				'default' => 'CURRENT_TIMESTAMP'
			])
			->addColumn('modified', 'timestamp', [
				'default' => 'CURRENT_TIMESTAMP',
				'update' => 'CURRENT_TIMESTAMP'
			])
			->create();

		$this->table('tusk_groups')
			->addColumn('name', 'string', [
				'default' => null,
				'limit' => 100,
				'null' => false,
			])
			->addColumn('active', 'boolean', [
				'default' => 1,
			])
			->addColumn('created', 'timestamp', [
				'default' => 'CURRENT_TIMESTAMP'
			])
			->addColumn('modified', 'timestamp', [
				'default' => 'CURRENT_TIMESTAMP',
				'update' => 'CURRENT_TIMESTAMP'
			])
			->create();

		$this->table('tusk_pages')
			->addColumn('name', 'string', [
				'default' => null,
				'limit' => 100,
				'null' => false,
			])
			->addColumn('active', 'boolean', [
				'default' => 1,
			])
			->addColumn('is_homepage', 'boolean', [
				'default' => 0,
			])
			->addColumn('type', 'integer', [
				'default' => 0,
			])
			->addColumn('parent', 'integer', [
				'default' => 0,
			])
			->addColumn('layout_id', 'integer', [
				'default' => 0,
			])
			->addColumn('created', 'timestamp', [
				'default' => 'CURRENT_TIMESTAMP'
			])
			->addColumn('modified', 'timestamp', [
				'default' => 'CURRENT_TIMESTAMP',
				'update' => 'CURRENT_TIMESTAMP'
			])
			->create();

		$this->table($layoutsTable)
			->addColumn('name', 'string', [
				'default' => null,
				'limit' => 100,
				'null' => false,
			])
			->addColumn('layout', 'string', [
				'default' => null,
			])
			->addColumn('active', 'boolean', [
				'default' => 1,
			])
			->addColumn('created', 'timestamp', [
				'default' => 'CURRENT_TIMESTAMP'
			])
			->addColumn('modified', 'timestamp', [
				'default' => 'CURRENT_TIMESTAMP',
				'update' => 'CURRENT_TIMESTAMP'
			])
			->create();
		
		$this->table($elementsTable)
			->addColumn('name', 'string', [
				'default' => null,
				'limit' => 100,
				'null' => false,
			])
			->addColumn('element', 'string', [
				'default' => null,
			])
			->addColumn('active', 'boolean', [
				'default' => 1,
			])
			->addColumn('created', 'timestamp', [
				'default' => 'CURRENT_TIMESTAMP'
			])
			->addColumn('modified', 'timestamp', [
				'default' => 'CURRENT_TIMESTAMP',
				'update' => 'CURRENT_TIMESTAMP'
			])
			->create();
		
		$this->table($contentsTable)
			->addColumn('page_id', 'integer', [
				'default' => Null,
			])
			->addColumn('element_id', 'integer', [
				'default' => Null,
			])
			->addColumn('text', 'string', [
				'default' => null,
				'null' => true,
			])
			->addColumn('html', 'text', [
				'default' => null,
				'null' => true,
			])
			->addColumn('active', 'boolean', [
				'default' => 1,
			])
			->addColumn('position', 'integer', [
				'default' => 0,
			])
			->addColumn('created', 'timestamp', [
				'default' => 'CURRENT_TIMESTAMP'
			])
			->addColumn('modified', 'timestamp', [
				'default' => 'CURRENT_TIMESTAMP',
				'update' => 'CURRENT_TIMESTAMP'
			])
			->create();

		if ($this->isMigratingUp()) {
			$this->table($userTable)
				->insert([
					[
						'name' => 'Carsten Coull',
						'email' => 'carsten.coull@swu.de',
						'password' => '$2y$10$ir6eCGhZ/F9Ah0pSRDJ05.4z0hfHQaV.3W20XCqaqNqoY1T7wSxQK'
					]
				])
				->saveData();

			$this->table($layoutsTable)
				->insert([
					[
						'name' => 'Default',
						'layout' => 'default',
					]
				])
				->saveData();
				
			$this->table($elementsTable)
				->insert([
					[
						'name' => 'Text',
						'element' => 'text',
					]
				])
				->saveData();
						
			$this->table($pagesTable)
				->insert([
					[
						'name' => 'Home',
						'is_homepage' => 1,
						'layout_id' => 1,
					]
				])
				->saveData();
					
			$this->table($contentsTable)
				->insert([
					[
						'page_id' => 1,
						'element_id' => 1,
						'text' => 'Welcome to Rhino 🦏',
						'html' => '<p>The fast but stable Application-Framwork.<br/>Powered by <a href="https://cakephp.org/">CakePHP</a>.</p>'
					]
				])
				->saveData();
		}
    }
}
