<?php
namespace App\Model;

use App\Service\Config;

class Wheels
{
    private ?int $id = null;
    private ?string $brand = null;
    private ?int $size = null;
    private ?string $color = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(?int $id): Wheels
    {
        $this->id = $id;

        return $this;
    }

    public function getBrand(): ?string
    {
        return $this->brand;
    }

    public function setBrand(?string $brand): Wheels
    {
        $this->brand = $brand;

        return $this;
    }

    public function getSize(): ?int
    {
        return $this->size;
    }

    public function setSize(?string $size): Wheels
    {
        $this->size = $size;

        return $this;
    }

    public function getColor(): ?string
    {
        return $this->color;
    }

    public function setColor(?string $color): Wheels
    {
        $this->color = $color;

        return $this;
    }

    public static function fromArray($array): Wheels
    {
        $wheel = new self();
        $wheel->fill($array);

        return $wheel;
    }

    public function fill($array): Wheels
    {
        if (isset($array['id']) && ! $this->getId()) {
            $this->setId($array['id']);
        }
        if (isset($array['brand'])) {
            $this->setBrand($array['brand']);
        }
        if (isset($array['size'])) {
            $this->setSize($array['size']);
        }
        if (isset($array['color'])) {
            $this->setColor($array['color']);
        }

        return $this;
    }

    public static function findAll(): array
    {
        $pdo = new \PDO(Config::get('db_dsn'), Config::get('db_user'), Config::get('db_pass'));
        $sql = 'SELECT * FROM wheels';
        $statement = $pdo->prepare($sql);
        $statement->execute();

        $wheels = [];
        $wheelsArray = $statement->fetchAll(\PDO::FETCH_ASSOC);
        foreach ($wheelsArray as $wheelArray) {
            $wheels[] = self::fromArray($wheelArray);
        }

        return $wheels;
    }

    public static function find($id): ?Wheels
    {
        $pdo = new \PDO(Config::get('db_dsn'), Config::get('db_user'), Config::get('db_pass'));
        $sql = 'SELECT * FROM wheels WHERE id = :id';
        $statement = $pdo->prepare($sql);
        $statement->execute(['id' => $id]);

        $wheelArray = $statement->fetch(\PDO::FETCH_ASSOC);
        if (! $wheelArray) {
            return null;
        }
        $wheels = Wheels::fromArray($wheelArray);

        return $wheels;
    }

    public function save(): void
    {
        $pdo = new \PDO(Config::get('db_dsn'), Config::get('db_user'), Config::get('db_pass'));
        if (! $this->getId()) {
            $sql = "INSERT INTO wheels (brand, size, color) VALUES (:brand, :size, :color)";
            $statement = $pdo->prepare($sql);
            $statement->execute([
                'brand' => $this->getBrand(),
                'size' => $this->getSize(),
                'color' => $this->getColor(),
            ]);

            $this->setId($pdo->lastInsertId());
        } else {
            $sql = "UPDATE wheels SET brand = :brand, size = :size, color = :color WHERE id = :id";
            $statement = $pdo->prepare($sql);
            $statement->execute([
                ':brand' => $this->getBrand(),
                ':size' => $this->getSize(),
                ':color' => $this->getColor(),
                ':id' => $this->getId(),
            ]);
        }
    }

    public function delete(): void
    {
        $pdo = new \PDO(Config::get('db_dsn'), Config::get('db_user'), Config::get('db_pass'));
        $sql = "DELETE FROM wheels WHERE id = :id";
        $statement = $pdo->prepare($sql);
        $statement->execute([
            ':id' => $this->getId(),
        ]);

        $this->setId(null);
        $this->setBrand(null);
        $this->setSize(null);
        $this->setColor(null);
    }
}
