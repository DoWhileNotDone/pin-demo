<?php

namespace Demo\Model;

use SQLite3;

/**
 *
 */
class Pin
{
    private int|null $pin;

    public function __construct(
        private SQLite3 $db,
    ) {}

    /**
     * Getter
     *
     * @return void
     */
    public function getPin(): int|null
    {
        return $this->pin;
    }

    /**
     * Setter
     *
     * @param integer $pin
     * @return Pin
     */
    public function setPin(int $pin): Pin
    {
        $this->pin = $pin;
        return $this;
    }

    /**
     * Generate a new pin value
     *
     * @return integer
     */
    public function generate(): int
    {
        return random_int(0, 9999);
    }

    /**
     * Check that the pin is unique in the db
     *
     * @return boolean
     */
    public function isUnique(): bool
    {
        $result = $this->db->query("select count(*) as existing from `existing_pins` where pin = {$this->getPin()};");
        $result = $result->fetchArray();
        return $result['existing'] === 0;
    }

    /**
     * Validate the pin against the supplied rules
     *
     * @param array $rules
     * @return boolean
     */
    public function validate(array $rules): bool
    {
        $valid = true;
        foreach ($rules as $rule) {
            if ($rule->validate($this) === false) {
                $valid = false;
                break;
            }
        }
        return $valid;
    }

    /**
     * Store the pin to the DB
     *
     * @return Pin
     */
    public function store(): Pin
    {
        $this->db->exec("insert into `existing_pins` (pin) values ({$this->getPin()});");
        return $this;
    }

    public function __toString()
    {
        return "{$this->pin}";
    }
}
