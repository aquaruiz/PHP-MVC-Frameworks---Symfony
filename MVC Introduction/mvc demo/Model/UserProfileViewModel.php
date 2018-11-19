<?php
/**
 * Created by PhpStorm.
 * User: vesel
 * Date: 11/12/2018
 * Time: 8:22 PM
 */

namespace Model;

class UserProfileViewModel
{
    /**
     * @var string
     */
    private $first_name;

    /**
     * @var string
     */
    private $last_name;

    /**
     * UserProfileViewModel constructor.
     * @param string $first_name
     * @param string $last_name
     */
    public function __construct(string $first_name, string $last_name)
    {
        $this->first_name = $first_name;
        $this->last_name = $last_name;
    }


    /**
     * @return string
     */
    public function getFirstName(): string
    {
        return $this->first_name;
    }

    /**
     * @return string
     */
    public function getLastName(): string
    {
        return $this->last_name;
    }


}