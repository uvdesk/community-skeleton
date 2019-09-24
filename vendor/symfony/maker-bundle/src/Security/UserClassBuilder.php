<?php

/*
 * This file is part of the Symfony MakerBundle package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Symfony\Bundle\MakerBundle\Security;

use PhpParser\Node;
use Symfony\Bundle\MakerBundle\Util\ClassSourceManipulator;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * Adds logic to implement UserInterface to an existing User class.
 *
 * @internal
 */
final class UserClassBuilder
{
    public function addUserInterfaceImplementation(ClassSourceManipulator $manipulator, UserClassConfiguration $userClassConfig)
    {
        $manipulator->addInterface(UserInterface::class);

        $this->addGetUsername($manipulator, $userClassConfig);

        $this->addGetRoles($manipulator, $userClassConfig);

        $this->addGetPassword($manipulator, $userClassConfig);

        $this->addGetSalt($manipulator, $userClassConfig);

        $this->addEraseCredentials($manipulator, $userClassConfig);
    }

    private function addGetUsername(ClassSourceManipulator $manipulator, UserClassConfiguration $userClassConfig)
    {
        if ($userClassConfig->isEntity()) {
            // add entity property
            $manipulator->addEntityField(
                $userClassConfig->getIdentityPropertyName(),
                [
                    'type' => 'string',
                    // https://github.com/FriendsOfSymfony/FOSUserBundle/issues/1919
                    'length' => 180,
                    'unique' => true,
                ]
            );
        } else {
            // add normal property
            $manipulator->addProperty($userClassConfig->getIdentityPropertyName());

            $manipulator->addGetter(
                $userClassConfig->getIdentityPropertyName(),
                'string',
                true
            );

            $manipulator->addSetter(
                $userClassConfig->getIdentityPropertyName(),
                'string',
                false
            );
        }

        // define getUsername (if it was defined above, this will override)
        $manipulator->addAccessorMethod(
            $userClassConfig->getIdentityPropertyName(),
            'getUsername',
            'string',
            false,
            [
                'A visual identifier that represents this user.',
                '',
                '@see UserInterface',
            ],
            true
        );
    }

    private function addGetRoles(ClassSourceManipulator $manipulator, UserClassConfiguration $userClassConfig)
    {
        if ($userClassConfig->isEntity()) {
            // add entity property
            $manipulator->addEntityField(
                'roles',
                [
                    'type' => 'json',
                ]
            );
        } else {
            // add normal property
            $manipulator->addProperty(
                'roles',
                [],
                new Node\Expr\Array_([], ['kind' => Node\Expr\Array_::KIND_SHORT])
            );

            $manipulator->addGetter(
                'roles',
                'array',
                false
            );

            $manipulator->addSetter(
                'roles',
                'array',
                false
            );
        }

        // define getRoles (if it was defined above, this will override)
        $builder = $manipulator->createMethodBuilder(
            'getRoles',
            'array',
            false,
            ['@see UserInterface']
        );

        // $roles = $this->roles
        $builder->addStmt(
            new Node\Stmt\Expression(new Node\Expr\Assign(
                new Node\Expr\Variable('roles'),
                new Node\Expr\PropertyFetch(new Node\Expr\Variable('this'), 'roles')
            ))
        );
        // comment line
        $builder->addStmt(
            $manipulator->createMethodLevelCommentNode(
                'guarantee every user at least has ROLE_USER'
            )
        );
        // $roles[] = 'ROLE_USER';
        $builder->addStmt(
            new Node\Stmt\Expression(
                new Node\Expr\Assign(
                    new Node\Expr\ArrayDimFetch(
                        new Node\Expr\Variable('roles')
                    ),
                    new Node\Scalar\String_('ROLE_USER')
                )
            )
        );
        $builder->addStmt($manipulator->createMethodLevelBlankLine());
        // return array_unique($roles);
        $builder->addStmt(
            new Node\Stmt\Return_(
                new Node\Expr\FuncCall(
                    new Node\Name('array_unique'),
                    [new Node\Expr\Variable('roles')]
                )
            )
        );

        $manipulator->addMethodBuilder($builder);
    }

    private function addGetPassword(ClassSourceManipulator $manipulator, UserClassConfiguration $userClassConfig)
    {
        if (!$userClassConfig->hasPassword()) {
            // add an empty method only
            $builder = $manipulator->createMethodBuilder(
                'getPassword',
                null,
                false,
                ['@see UserInterface']
            );
            $builder->addStmt(
                $manipulator->createMethodLevelCommentNode(
                    'not needed for apps that do not check user passwords'
                )
            );

            $manipulator->addMethodBuilder($builder);

            return;
        }

        $propertyDocs = '@var string The hashed password';
        if ($userClassConfig->isEntity()) {
            // add entity property
            $manipulator->addEntityField(
                'password',
                [
                    'type' => 'string',
                ],
                [$propertyDocs]
            );
        } else {
            // add normal property
            $manipulator->addProperty('password', [$propertyDocs]);

            $manipulator->addGetter(
                'password',
                'string',
                true
            );

            $manipulator->addSetter(
                'password',
                'string',
                false
            );
        }

        // define getPassword (if it was defined above, this will override)
        $manipulator->addAccessorMethod(
            'password',
            'getPassword',
            'string',
            false,
            [
                '@see UserInterface',
            ],
            true
        );
    }

    private function addGetSalt(ClassSourceManipulator $manipulator, UserClassConfiguration $userClassConfig)
    {
        // add getSalt(): always empty
        $builder = $manipulator->createMethodBuilder(
            'getSalt',
            null,
            false,
            ['@see UserInterface']
        );
        if ($userClassConfig->hasPassword()) {
            $builder->addStmt(
                $manipulator->createMethodLevelCommentNode(
                    'not needed when using the "bcrypt" algorithm in security.yaml'
                )
            );
        } else {
            $builder->addStmt(
                $manipulator->createMethodLevelCommentNode(
                    'not needed for apps that do not check user passwords'
                )
            );
        }

        $manipulator->addMethodBuilder($builder);
    }

    private function addEraseCredentials(ClassSourceManipulator $manipulator, UserClassConfiguration $userClassConfig)
    {
        // add eraseCredentials: always empty
        $builder = $manipulator->createMethodBuilder(
            'eraseCredentials',
            null,
            false,
            ['@see UserInterface']
        );
        $builder->addStmt(
            $manipulator->createMethodLevelCommentNode(
                'If you store any temporary, sensitive data on the user, clear it here'
            )
        );
        $builder->addStmt(
            $manipulator->createMethodLevelCommentNode(
                '$this->plainPassword = null;'
            )
        );

        $manipulator->addMethodBuilder($builder);
    }
}
