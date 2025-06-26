<?php

namespace App\Backend\Models;

use Phalcon\Mvc\Model;

/**
 * @Source("test")
 */
class Test extends Model
{
    /**
     * @Primary
     * @Identity
     * @Column(type="integer", nullable=false)
     */
    protected ?string $id = null;

    /**
     * @Column(type="string", nullable=true)
     */
    protected string $name;

    // Getters
    public function getId(): int
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }


    // Setters
    public function setName(string $name): void
    {
        $this->name = $name;
    }

}
