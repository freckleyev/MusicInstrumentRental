<?php

namespace App\DataFixtures;

use App\Entity\Categories;
use App\Entity\Instruments;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
      
        // CATEGORIES
        $strings = new Categories();
        $strings->setName('Strings');

        $keyboard = new Categories();
        $keyboard->setName('Keyboard');

        $percussion = new Categories();
        $percussion->setName('Percussion');

        $woodwind = new Categories();
        $woodwind->setName('Woodwind');

        $brass = new Categories();
        $brass->setName('Brass');

        // Save categories
        $manager->persist($strings);
        $manager->persist($keyboard);
        $manager->persist($percussion);
        $manager->persist($woodwind);
        $manager->persist($brass);

        
        // INSTRUMENTS
        $guitar = new Instruments();

        $guitar->setName('Fender Guitar');
        $guitar->setInstrumentCondition('Good');
        $guitar->setDescription(
            'A great guitar for beginners and experienced players.'
        );
        $guitar->setDailyRentalPrice('15.00');
        $guitar->setIsActive(true);
        $guitar->setCategory($strings);
        $guitar->setImage('guitar.jpg');


        $manager->persist($guitar);



        $piano = new Instruments();

        $piano->setName('Yamaha Piano');
        $piano->setInstrumentCondition('Excellent');
        $piano->setDescription(
            'A quality piano suitable for learning and practicing.'
        );
        $piano->setDailyRentalPrice('30.00');
        $piano->setIsActive(true);
        $piano->setCategory($keyboard);
        $piano->setImage('piano.jpg');

        $manager->persist($piano);



        $violin = new Instruments();

        $violin->setName('Yamaha Violin');
        $violin->setInstrumentCondition('Good');
        $violin->setDescription(
            'A lightweight violin ideal for beginners.'
        );
        $violin->setDailyRentalPrice('12.00');
        $violin->setIsActive(true);
        $violin->setCategory($strings);
        $violin->setImage('violin.jpg');

        $manager->persist($violin);



        $drums = new Instruments();

        $drums->setName('Pearl Drum Kit');
        $drums->setInstrumentCondition('Good');
        $drums->setDescription(
            'A complete drum kit suitable for practice and performance.'
        );
        $drums->setDailyRentalPrice('25.00');
        $drums->setIsActive(true);
        $drums->setCategory($percussion);
        $drums->setImage('drum.jpg');

        $manager->persist($drums);



        $flute = new Instruments();

        $flute->setName('Yamaha Flute');
        $flute->setInstrumentCondition('Excellent');
        $flute->setDescription(
            'A beginner-friendly flute with a clear and beautiful tone.'
        );
        $flute->setDailyRentalPrice('14.00');
        $flute->setIsActive(true);
        $flute->setCategory($woodwind);
        $flute->setImage('flute.jpg');

        $manager->persist($flute);



        $trumpet = new Instruments();

        $trumpet->setName('Yamaha Trumpet');
        $trumpet->setInstrumentCondition('Good');
        $trumpet->setDescription(
            'A reliable trumpet suitable for beginners.'
        );
        $trumpet->setDailyRentalPrice('18.00');
        $trumpet->setIsActive(true);
        $trumpet->setCategory($brass);
        $trumpet->setImage('trumpet.jpg');

        $manager->persist($trumpet);


        // Save everything to the database

        $manager->flush();
    }
}