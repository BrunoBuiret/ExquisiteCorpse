<?php

namespace ExquisiteCorpse\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;

/**
 * Class GameType
 *
 * @package ExquisiteCorpse\Type
 * @author Thomas Arnaud <thomas.arnaud@etu.univ-lyon1.fr>
 * @author Bruno Buiret <bruno.buiret@etu.univ-lyon1.fr>
 * @author Bastien Guyl <bastien.guyl@etu.univ-lyon1.fr>
 * @author Alexis Rabilloud <alexis.rabilloud@etu.univ-lyon1.fr>
 * @version 1.0
 */
class GameType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add(
                'game',
                TextType::class,
                array(
                    'required' => false
                )
            )
        ;
    }
}