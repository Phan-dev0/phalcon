<?php

namespace App\Backend\Forms;

use Phalcon\Forms\Form;
use Phalcon\Forms\Element\Text;
use Phalcon\Forms\Element\Select;
use Phalcon\Forms\Element\Submit;
use Phalcon\Forms\Element\TextArea;
use App\Backend\Models\User;
use Phalcon\Forms\Element\Hidden;
use Phalcon\Filter\Validation\Validator\Identical;


class CreateAndUpdatePostForm extends Form
{
    public function initialize($entity = null, $options = [])
    {
        // User ID Select
        $this->add(new Select(
            'user_id',
            User::find(),
            [
                'using'      => ['id', 'username'],
                'useEmpty'   => true,
                'emptyText'  => 'Select a user',
                'emptyValue' => '',
            ]
        ));

        // Title Textbox
        $this->add(new Text('title', [
            'placeholder' => 'Enter Title'
        ]));

        // Title Textbox
        $this->add(new TextArea('content', [
            'placeholder' => 'Enter Content'
        ]));

        // Submit Button
        $this->add(new Submit('filter', [
            'value' => 'Filter',
            'class' => 'btn btn-filter'
        ]));

    }
}