<?php

namespace App\Controller;

use App\Entity\Autoservice;
use App\Form\AutoserviceType;
use App\Repository\AutoserviceRepository;
use App\Repository\ServiceRepository;
use PhpParser\Node\Scalar\String_;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/autoservice")
 */
class AutoserviceController extends AbstractController
{
    /**
     * @Route("/", name="autoservice_index", methods={"GET"})
     */
    public function index(AutoserviceRepository $autoserviceRepository): Response
    {
        return $this->render('autoservice/index.html.twig', [
            'autoservices' => $autoserviceRepository->findAll(),
        ]);
    }

    public function start_with(string $haystack, string $needle)
    {
        $length = strlen($needle);
        return (substr($haystack, 0, $length) === $needle);
    }

    public function parse_services(string $bodyStr) {

    $result =[];
    $values = explode('&',$bodyStr);
    $FOR_FIND = "servicesCheck";
    foreach($values as $value) {
        if(strstr($value,$FOR_FIND) == false){
            continue;
        }
        $pair = explode('=',$value);
        if(strcmp($pair[1],"on") == 0){
            $result[] = (int)(substr($pair[0], strlen($FOR_FIND)));
            }
        }
    return $result;
    }

    public function console_log() {
        static $f = false;
        if (!func_num_args()) return; # Аргументы не переданы
        if (!$f) $f = fopen('!console.log',"w");
        foreach (func_get_args() as $arg) {
            if (is_bool($arg)) $s = $arg?'TRUE':'FALSE';
            elseif (is_array($arg) or is_object($arg)) $s = print_r($arg, TRUE);
            else $s = $arg;
            fwrite($f,$s.' '); # вывод аргументов разделяется пробелом
        }
    }
    /**
     * @Route("/new", name="autoservice_new", methods={"GET","POST"})
     */
    public function new(Request $request, ServiceRepository $serviceRepository): Response
    {
        $autoservice = new Autoservice();
        $allServices = $serviceRepository->findAll();
        $form = $this->createForm(AutoserviceType::class, $autoservice);
        $form->handleRequest($request);

        $this->console_log($request->getContent());

        if ($form->isSubmitted() && $form->isValid()) {
            $services = $this->parse_services($request->getContent());
            $autoservice->removeAllServices();
            if(empty($autoservice->getPhoto())){
                $autoservice->setPhoto('/static/assets/no-image.png');
            }else if(stristr($autoservice->getPhoto(), '/static/assets/') == false){
                $autoservice->setPhoto('/static/assets/services/'.$autoservice->getPhoto());
            }
            foreach($services as $value){
                $autoservice->addService($serviceRepository->find($value));
            }
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($autoservice);
            $entityManager->flush();

            return $this->redirectToRoute('autoservice_index');
        }

        return $this->render('autoservice/new.html.twig', [
            'autoservice' => $autoservice,
            'idServices' => [],
            'allServices' =>$allServices,
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/{id}", name="autoservice_show", methods={"GET"})
     */
    public function show(Autoservice $autoservice,   ServiceRepository $serviceRepository): Response
    {
        $allServices = $serviceRepository->findAll();
        $servicesAutoservice = $autoservice->getServices();
        $res = [];
        foreach($allServices as $value){
            if($servicesAutoservice->contains($value)){
                $res[] = $value->getId();
            }
        }
        return $this->render('autoservice/show.html.twig', [
            'autoservice' => $autoservice,
            'allServices' =>$allServices,
            'idServices' =>$res
        ]);
    }

    /**
     * @Route("/{id}/edit", name="autoservice_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Autoservice $autoservice,  ServiceRepository $serviceRepository): Response
    {
        $allServices = $serviceRepository->findAll();
        $servicesAutoservice = $autoservice->getServices();
        $res = [];
        foreach($allServices as $value){
            if($servicesAutoservice->contains($value)){
                $res[] = $value->getId();
            }
        }
        $form = $this->createForm(AutoserviceType::class, $autoservice);
        $form->handleRequest($request);

        $this->console_log($request->getContent());
        if ($form->isSubmitted() && $form->isValid()) {
            $services = $this->parse_services($request->getContent());
            $autoservice->removeAllServices();
            if(empty($autoservice->getPhoto())){
                $autoservice->setPhoto('/static/assets/no-image.png');
            }else if(stristr($autoservice->getPhoto(), '/static/assets/') == false){
                $autoservice->setPhoto('/static/assets/services/'.$autoservice->getPhoto());
            }
            foreach($services as $value){
                $autoservice->addService($serviceRepository->find($value));
            }
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('autoservice_index');
        }

        return $this->render('autoservice/edit.html.twig', [
            'autoservice' => $autoservice,
             'allServices' =>$allServices,
            'idServices' =>$res,
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/{id}", name="autoservice_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Autoservice $autoservice): Response
    {
        if ($this->isCsrfTokenValid('delete'.$autoservice->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($autoservice);
            $entityManager->flush();
        }

        return $this->redirectToRoute('autoservice_index');
    }
}
