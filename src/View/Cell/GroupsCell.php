<?php
declare(strict_types=1);

namespace Tusk\View\Cell;

use Cake\View\Cell;

/**
 * Sidebar cell
 */
class GroupsCell extends Cell {
    /**
     * List of valid options that can be passed into this
     * cell's constructor.
     *
     * @var array<string, mixed>
     */
    protected $_validCellOptions = [];

    /**
     * Initialization logic run at the end of object construction.
     *
     * @return void
     */
    public function initialize(): void {
		$this->Groups = $this->fetchTable('Tusk.Groups');
    }

    /**
     * Default display method.
     *
     * @return void
     */
    public function display() {
		$Groups = $this->Groups->find('all')->contain(['Applications'])->all();
		$this->set(["groups" => $Groups]);
    }
}