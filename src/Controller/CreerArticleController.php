<?php

namespace App\Controller;

use App\Entity\Articles;
use App\Entity\Categories;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class CreerArticleController extends AbstractController
{
    /**
     * @Route("/creer/article", name="creer_article")
     */
    public function creerArticle(Request $request)
    {
        // creates a task object and initializes some data for this example
        $article = new Articles();

        $form = $this->createFormBuilder($article)
            ->add("nomarticle", TextType::class, ['label' => 'Nom'])
            ->add("imagearticle", FileType::class, [
                'label' => 'Image'])
            ->add("prixarticle", NumberType::class, ['label' => 'Prix'])
            ->add("descriptionarticle", TextareaType::class, ['label' => 'Description'])
            ->add("type", HiddenType::class, [
                'attr' => ['value' => 'new'],
            ])
            ->add("idcategorie", EntityType::class, [
                'class' => Categories::class,
                'choice_label' => 'nomcategorie',
                'label' => 'Catégorie',
            ])
            ->add('Enregistrer', SubmitType::class, ['label' => 'Enregistrer'])
            ->getForm();

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            // $form->getData() holds the submitted values
            // but, the original `$task` variable has also been updated
            $file = $form['imagearticle']->getData();
            $extension = $file->guessExtension();
            if (!$extension) {
                // extension cannot be guessed
                $extension = 'jpg';
            }
            $directory = $this->getParameter('images_directory');
            $name = rand(1, 99999) . '.' . $extension;
            $file->move($directory, $name);
            $article = $form->getData();
            $article->setImagearticle($name);
            dump($article);
            // ... perform some action, such as saving the task to the database
            // for example, if Task is a Doctrine entity, save it!
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($article);
            $entityManager->flush();

            return $this->redirectToRoute('creer_article');
        }
        return $this->render('creer_article/index.html.twig', [
            'form' => $form->createView(),
        ]);
    }

}