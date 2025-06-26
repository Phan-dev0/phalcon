<?php

namespace App\Backend\Forms;

use Phalcon\Forms\Form;
use Phalcon\Forms\Element\Text;
use Phalcon\Forms\Element\Select;
use Phalcon\Forms\Element\Date;
use Phalcon\Forms\Element\Submit;
use App\Backend\Models\User;
use Phalcon\Forms\Element\Hidden;
use Phalcon\Filter\Validation\Validator\Identical;




class PostFilterForm extends Form
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
                'emptyText'  => 'All Users',
                'emptyValue' => '',
            ]
        ));

        // Title Textbox
        $this->add(new Text('title', [
            'placeholder' => 'Search Title'
        ]));

        // From Date
        $this->add(new Date('from_date'));

        // To Date
        $this->add(new Date('to_date'));

        // Submit Button
        $this->add(new Submit('filter', [
            'value' => 'Filter',
            'class' => 'btn btn-filter'
        ]));

    }
}