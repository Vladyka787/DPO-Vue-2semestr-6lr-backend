<?php

namespace App\Controller;

use App\Entity\EducationInformation;
use App\Entity\Resume;
use App\Repository\ResumeRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class ApiController extends AbstractController
{
    private ManagerRegistry $doctrine;

    public function __construct(ManagerRegistry $doctrine)
    {
        $this->doctrine = $doctrine;
    }
//  Получение резюме
    #[Route('api/cv', name: 'api_cv', methods: 'GET')]
    public function getResumes(): JsonResponse
    {
        $resumeRepository = $this->doctrine->getRepository(Resume::class);
        $resumes = $resumeRepository->findAll();

        $result = [];
        for ($i = 0, $iMax = count($resumes); $i < $iMax; $i++) {
            $result[$i]['id'] = $resumes[$i]->getId();
            $result[$i]['status'] = $resumes[$i]->getStatus();
            $result[$i]['first_name'] = $resumes[$i]->getFirstName();
            $result[$i]['last_name'] = $resumes[$i]->getLastName();
            $result[$i]['patronymic'] = $resumes[$i]->getPatronymic();
            $result[$i]['city'] = $resumes[$i]->getCity();
            $result[$i]['photo'] = $resumes[$i]->getPhoto();
            $result[$i]['profession'] = $resumes[$i]->getProfession();
            $result[$i]['phone_number'] = $resumes[$i]->getPhoneNumber();
            $result[$i]['email'] = $resumes[$i]->getEmail();
            $result[$i]['birthdate'] = $resumes[$i]->getBirthdate();
            $result[$i]['level_of_education'] = $resumes[$i]->getLevelOfEducation();
            $educationInformation = $resumes[$i]->getEducationInformation();
            for ($j = 0, $jMax = count($educationInformation); $j < $jMax; $j++) {
                $result[$i]['education_information'][$j]['educational_institution'] = $educationInformation[$j]->getEducationalInstitution();
                $result[$i]['education_information'][$j]['faculty'] = $educationInformation[$j]->getFaculty();
                $result[$i]['education_information'][$j]['specialization'] = $educationInformation[$j]->getSpecialization();
                $result[$i]['education_information'][$j]['year_of_ending'] = $educationInformation[$j]->getYearOfEnding();
            }
            $result[$i]['salary'] = $resumes[$i]->getSalary();
            $result[$i]['key_skills'] = $resumes[$i]->getKeySkills();
            $result[$i]['about_me'] = $resumes[$i]->getAboutMe();
        }

        return new JsonResponse($result, 200);
    }

//  Получение резюме по айди
    #[Route('api/cv/{id}', name: 'api_cv_id', methods: 'GET')]
    public function getResumeById(
        Request $request,
    ): JsonResponse
    {
        $id = $request->get('id');

        $result = [];

        $resumeRepository = $this->doctrine->getRepository(Resume::class);
        $resume = $resumeRepository->find($id);

        if ($resume != null) {
            $result['id'] = $resume->getId();
            $result['status'] = $resume->getStatus();
            $result['first_name'] = $resume->getFirstName();
            $result['last_name'] = $resume->getLastName();
            $result['patronymic'] = $resume->getPatronymic();
            $result['city'] = $resume->getCity();
            $result['photo'] = $resume->getPhoto();
            $result['profession'] = $resume->getProfession();
            $result['phone_number'] = $resume->getPhoneNumber();
            $result['email'] = $resume->getEmail();
            $result['birthdate'] = $resume->getBirthdate();
            $result['level_of_education'] = $resume->getLevelOfEducation();
            $educationInformation = $resume->getEducationInformation();
            for ($j = 0, $jMax = count($educationInformation); $j < $jMax; $j++) {
                $result['education_information'][$j]['educational_institution'] = $educationInformation[$j]->getEducationalInstitution();
                $result['education_information'][$j]['faculty'] = $educationInformation[$j]->getFaculty();
                $result['education_information'][$j]['specialization'] = $educationInformation[$j]->getSpecialization();
                $result['education_information'][$j]['year_of_ending'] = $educationInformation[$j]->getYearOfEnding();
            }
            $result['salary'] = $resume->getSalary();
            $result['key_skills'] = $resume->getKeySkills();
            $result['about_me'] = $resume->getAboutMe();
        }

        if ($result != []) {
            return new JsonResponse($result, 200);
        } else {
            return new JsonResponse(['error' => 'Не существует резюме с таким айди'], 406);
        }
    }
//  Создание резюме
    #[Route('api/cv/add', name: 'api_cv_add', methods: 'POST')]
    public function createResume(
        Request $request,
    ): JsonResponse
    {
        $content = json_decode($request->getContent(), true);

        $status = $content['status'];
        $firstName = $content['first_name'];
        $lastName = $content['last_name'];
        $patronymic = $content['patronymic'];
        $city = $content['city'];
        $photo = $content['photo'];
        $profession = $content['profession'];
        $phoneNumber = $content['phone_number'];
        $email = $content['email'];
        $birthdate = $content['birthdate'];
        $levelOfEducation = $content['level_of_education'];
        $educationInformation = $content['education_information'];
        $salary = $content['salary'];
        $keySkills = $content['key_skills'];
        $aboutMe = $content['about_me'];

        $resume = new Resume();
        $resume->setFirstName($firstName);
        $resume->setLastName($lastName);
        $resume->setPatronymic($patronymic);
        $resume->setStatus($status);
        $resume->setCity($city);
        $resume->setPhoto($photo);
        $resume->setProfession($profession);
        $resume->setPhoneNumber($phoneNumber);
        $resume->setEmail($email);
        $resume->setBirthdate($birthdate);
        $resume->setLevelOfEducation($levelOfEducation);
        $resume->setSalary($salary);
        $resume->setKeySkills($keySkills);
        $resume->setAboutMe($aboutMe);


        $manager = $this->doctrine->getManager();

        $manager->persist($resume);

        foreach ($educationInformation as $education) {
            $educationInformationNew = new EducationInformation();
            $educationInformationNew->setEducationalInstitution($education['educational_institution']);
            $educationInformationNew->setFaculty($education['faculty']);
            $educationInformationNew->setSpecialization($education['specialization']);
            $educationInformationNew->setYearOfEnding($education['year_of_ending']);
            $educationInformationNew->setResume($resume);
            $manager->persist($educationInformationNew);
            $resume->addEducationInformation($educationInformationNew);
        }

        $manager->flush();

        return new JsonResponse(['message' => 'Успешно'], 201);
    }

//  Редактирование резюме
    #[Route('api/cv/{id}/edit', name: 'api_cv_id_edit', methods: 'POST')]
    public function editResume(
        Request          $request,
        ResumeRepository $resumeRepository,
        int $id
    ): JsonResponse
    {
        $content = json_decode($request->getContent(), true);

        $status = $content['status'];
        $firstName = $content['first_name'];
        $lastName = $content['last_name'];
        $patronymic = $content['patronymic'];
        $city = $content['city'];
        $photo = $content['photo'];
        $profession = $content['profession'];
        $phoneNumber = $content['phone_number'];
        $email = $content['email'];
        $birthdate = $content['birthdate'];
        $levelOfEducation = $content['level_of_education'];
        $educationInformation = $content['education_information'];
        $salary = $content['salary'];
        $keySkills = $content['key_skills'];
        $aboutMe = $content['about_me'];

        $resume = $resumeRepository->find($id);

        if ($resume == null) {
            return new JsonResponse(
                ['error' => 'Не существует резюме с таким айди'],
                406
            );
        }

        $resume->setFirstName($firstName);
        $resume->setLastName($lastName);
        $resume->setPatronymic($patronymic);
        $resume->setStatus($status);
        $resume->setCity($city);
        $resume->setPhoto($photo);
        $resume->setProfession($profession);
        $resume->setPhoneNumber($phoneNumber);
        $resume->setEmail($email);
        $resume->setBirthdate($birthdate);
        $resume->setLevelOfEducation($levelOfEducation);
        $resume->setSalary($salary);
        $resume->setKeySkills($keySkills);
        $resume->setAboutMe($aboutMe);

        $educationInformationOld = $resume->getEducationInformation();

        foreach ($educationInformationOld as $educationOld) {
            $resume->removeEducationInformation($educationOld);
        }

        $manager = $this->doctrine->getManager();

        $manager->persist($resume);

        foreach ($educationInformation as $education) {
            $educationInformationNew = new EducationInformation();
            $educationInformationNew->setEducationalInstitution($education['educational_institution']);
            $educationInformationNew->setFaculty($education['faculty']);
            $educationInformationNew->setSpecialization($education['specialization']);
            $educationInformationNew->setYearOfEnding($education['year_of_ending']);
            $educationInformationNew->setResume($resume);
            $manager->persist($educationInformationNew);
            $resume->addEducationInformation($educationInformationNew);
        }

        $resumeRepository->save($resume, true);

        return new JsonResponse(['message' => 'Успешно'], 200);
    }

//  Обновить статус резюме
    #[Route('api/cv/{id}/status/update', name: 'api_cv_id_status_update', methods: 'POST')]
    public function updateStatus(
        Request          $request,
        ResumeRepository $resumeRepository,
        int $id
    ): JsonResponse
    {
        $content = json_decode($request->getContent(), true);

        $status = $content['status'];

        $resume = $resumeRepository->find($id);

        if ($resume == null) {
            return new JsonResponse(
                ['error' => 'Не существует резюме с таким айди'],
                406
            );
        }

        $resume->setStatus($status);

        $resumeRepository->save($resume, true);

        return new JsonResponse(['message' => 'Успешно'], 200);
    }

}