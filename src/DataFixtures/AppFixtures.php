<?php
/**
 * Created by PhpStorm.
 */

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use App\Entity\Staff;
use App\Entity\Room;
use App\Entity\Equipement;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {

        $staff = new Staff();
        $staff->setFirstName('Julie');
        $staff->setLastName('VAILLANT');
        $manager->persist($staff);

        $staff = new Staff();
        $staff->setFirstName('Cynthia');
        $staff->setLastName('FONSECA');
        $manager->persist($staff);

        $staff = new Staff();
        $staff->setFirstName('Pauline');
        $staff->setLastName('BOULAS');
        $manager->persist($staff);

        $staff = new Staff();
        $staff->setFirstName('Ludovic');
        $staff->setLastName('COURTOIS');
        $manager->persist($staff);

        $staff = new Staff();
        $staff->setFirstName('Sylvie');
        $staff->setLastName('PARFUM');
        $manager->persist($staff);

        $equipement = new equipement();
        $equipement->setName('Clef');
        $manager->persist($equipement);

        $equipement = new equipement();
        $equipement->setName('Cable HDMI');
        $manager->persist($equipement);

        $equipement = new equipement();
        $equipement->setName('Badge');
        $manager->persist($equipement);

        $equipement = new equipement();
        $equipement->setName('Adaptateur VGA');
        $manager->persist($equipement);

        $equipement = new equipement();
        $equipement->setName('Ordinateur portable');
        $manager->persist($equipement);

        $equipement = new equipement();
        $equipement->setName('Microphone');
        $manager->persist($equipement);

        $equipement = new equipement();
        $equipement->setName('Clef du local technique');
        $manager->persist($equipement);

        $equipement = new equipement();
        $equipement->setName('Aspirateur');
        $manager->persist($equipement);

        $equipement = new equipement();
        $equipement->setName('Chariot');
        $manager->persist($equipement);

        $equipement = new equipement();
        $equipement->setName('Plastifieuse');
        $manager->persist($equipement);

        $room = new Room();
        $room->setName('Showroom');
        $room->setDoor(1);
        $manager->persist($room);

        $room = new Room();
        $room->setName('Délirium');
        $room->setDoor(1);
        $manager->persist($room);

        $room = new Room();
        $room->setName('Fabrique');
        $room->setDoor(1);
        $manager->persist($room);

        $room = new Room();
        $room->setName('Hub 1');
        $room->setDoor(1);
        $manager->persist($room);

        $room = new Room();
        $room->setName('Hub 2');
        $room->setDoor(1);
        $manager->persist($room);

        $room = new Room();
        $room->setName('Shaker');
        $room->setDoor(1);
        $manager->persist($room);

        $room = new Room();
        $room->setName('Imaginarium');
        $room->setDoor(1);
        $manager->persist($room);

        $room = new Room();
        $room->setName('Tipi');
        $room->setDoor(1);
        $manager->persist($room);

        $room = new Room();
        $room->setName('Bulle 1');
        $room->setDoor(2);
        $manager->persist($room);

        $room = new Room();
        $room->setName('Bulle 2');
        $room->setDoor(2);
        $manager->persist($room);

        $room = new Room();
        $room->setName('Bootcamp');
        $room->setDoor(1);
        $manager->persist($room);

        $room = new Room();
        $room->setName('Club');
        $room->setDoor(2);
        $manager->persist($room);

        $room = new Room();
        $room->setName('Ruche');
        $room->setDoor(1);
        $manager->persist($room);

        $room = new Room();
        $room->setName('Tremplin');
        $room->setDoor(1);
        $manager->persist($room);

        $manager->flush();
    }
}
