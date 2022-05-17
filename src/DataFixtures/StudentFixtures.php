<?php

namespace App\DataFixtures;

use App\Entity\Student;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class StudentFixtures extends Fixture
{
    private UserPasswordHasherInterface $passwordHasher;

    public function __construct(UserPasswordHasherInterface $passwordHasher)
    {
        $this->passwordHasher = $passwordHasher;
    }

    public function load(ObjectManager $manager): void
    {
         $student = new Student();
         $student->setFirstname('Benice');
         $student->setLastname('B');
         $student->setStudentNumber('79458');
         $plaintextPassword = '#1Geheim';
         $hashedPassword = $this->passwordHasher->hashPassword(
            $student,
            $plaintextPassword
         );
         $student->setPassword($hashedPassword);
         $manager->persist($student);

        $student = new Student();
        $student->setFirstname('Benice');
        $student->setLastname('B');
        $student->setStudentNumber('12345');
        $plaintextPassword = '#1Geheim';
        $hashedPassword = $this->passwordHasher->hashPassword(
            $student,
            $plaintextPassword
        );
        $student->setPassword($hashedPassword);
        $manager->persist($student);

        $manager->flush();
    }
}
