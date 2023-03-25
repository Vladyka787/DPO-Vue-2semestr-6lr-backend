<?php

namespace App\DataFixtures;

use App\Entity\EducationInformation;
use App\Entity\Resume;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        // $product = new Product();
        // $manager->persist($product);

        $resume1 = new Resume();
        $resume1->setFirstName("Дмитрий");
        $resume1->setLastName("Сетченов");
        $resume1->setPatronymic("Сергеевич");
        $resume1->setStatus("Новый");
        $resume1->setCity("Москва");
        $resume1->setPhoto("https://mundfish.com/wp-content/uploads/sechenov_01-1.jpg");
        $resume1->setProfession("директор Предприятия 3826");
        $resume1->setPhoneNumber("88005553535");
        $resume1->setEmail("setchenov@mail.ru");
        $resume1->setBirthdate("1903-01-01");
        $resume1->setLevelOfEducation("Высшее");
        $resume1->setSalary("250000");
        $resume1->setKeySkills("Целеустремленный");
        $resume1->setAboutMe("Министр промышленности и глава Предприятия 3826, выдающийся учёный своего времени, советский футурист, нейрохирург, робототехник, один из создателей нейросети «Коллектив».");

        $manager->persist($resume1);

        $educationInformation1 = new EducationInformation();
        $educationInformation1->setEducationalInstitution("МГУ");
        $educationInformation1->setFaculty("Биологии");
        $educationInformation1->setSpecialization("Ученый");
        $educationInformation1->setYearOfEnding(1925);
        $educationInformation1->setResume($resume1);

        $manager->persist($educationInformation1);

        $educationInformation2 = new EducationInformation();
        $educationInformation2->setEducationalInstitution("МГУ");
        $educationInformation2->setFaculty("Информатики");
        $educationInformation2->setSpecialization("Программист");
        $educationInformation2->setYearOfEnding(1927);
        $educationInformation2->setResume($resume1);

        $manager->persist($educationInformation2);

        $resume1->addEducationInformation($educationInformation1);
        $resume1->addEducationInformation($educationInformation2);

        $manager->flush();
    }
}
