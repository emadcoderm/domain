<?php

namespace DomainProvider\Forms\Admin;

use Kris\LaravelFormBuilder\Form;

class SettingForm extends Form
{
    public function buildForm()
    {
        $this
            // web
            ->add('keyword', 'text', [
                'label' => trans('admin.setting.field_keyword'),
            ])
            ->add('description', 'text', [
                'label' => trans('admin.setting.field_description'),
            ])
            ->add('page_title', 'text', [
                'label' => trans('admin.setting.field_page_title'),
            ])
            ->add('lead_text', 'text', [
                'label' => trans('admin.setting.field_lead_title'),
            ])
            ->add('google_analytics', 'text', [
                'label' => trans('admin.setting.field_google_analytics'),
            ])
            // homepage
            ->add('middle_title', 'text', [
                'label' => trans('admin.setting.field_middle_title'),
            ])
            ->add('middle_body', 'text', [
                'label' => trans('admin.setting.field_middle_body'),
            ])
            ->add('footer_left_title', 'text', [
                'label' => trans('admin.setting.field_footer_left_title'),
            ])
            ->add('footer_left_body', 'textarea', [
                'label' => trans('admin.setting.field_footer_left_body'),
                'attr' => [
                    'class' => 'form-control whtml5',
                ]
            ])
            ->add('footer_right_title', 'text', [
                'label' => trans('admin.setting.field_footer_right_title'),
            ])
            ->add('footer_right_body', 'textarea', [
                'label' => trans('admin.setting.field_footer_right_body'),
                'attr' => [
                    'class' => 'form-control whtml5',
                ]
            ])
            ->add('footer_social_title', 'text', [
                'label' => trans('admin.setting.field_footer_social_title'),
            ])
            ->add('footer_social_facebook', 'text', [
                'label' => trans('admin.setting.field_footer_social_facebook'),
            ])
            ->add('footer_social_twitter', 'text', [
                'label' => trans('admin.setting.field_footer_social_twitter'),
            ])
            ->add('footer_social_googleplus', 'text', [
                'label' => trans('admin.setting.field_footer_social_googleplus'),
            ])
            ->add('footer_social_pinterest', 'text', [
                'label' => trans('admin.setting.field_footer_social_pinterest'),
            ])
            ->add('footer_social_linkedin', 'text', [
                'label' => trans('admin.setting.field_footer_social_linkedin'),
            ])
            ->add('footer_social_instagram', 'text', [
                'label' => trans('admin.setting.field_footer_social_instagram'),
            ])
            ->add('footer_social_youtube', 'text', [
                'label' => trans('admin.setting.field_footer_social_youtube'),
            ])
            // domain
            ->add('domain_min_chars', 'number', [
                'label' => trans('admin.setting.field_domain_min_chars'),
                'attr' => [
                    'min' => '0',
                    'max' => '255',
                ],
            ])
            ->add('domain_max_chars', 'number', [
                'label' => trans('admin.setting.field_domain_max_chars'),
                'attr' => [
                    'min' => '0',
                    'max' => '255',
                ],
            ])
            ->add('domain_registration_year', 'number', [
                'label' => trans('admin.setting.field_domain_registration_year'),
                'attr' => [
                    'min' => '1',
                    'max' => '10',
                ],
                'help_block' => [
                    'text' => trans('admin.setting.help.domain_registration_year'),
                ]
            ])
            ->add('domains_per_user', 'number', [
                'label' => trans('admin.setting.field_domains_per_user'),
                'attr' => [
                    'min' => '3',
                    'max' => '10',
                ],
                'help_block' => [
                    'text' => trans('admin.setting.help.domains_per_user'),
                ]
            ])
            ->add('dns_per_domain', 'number', [
                'label' => trans('admin.setting.field_dns_per_domain'),
                'attr' => [
                    'min' => '0',
                    'max' => '10',
                ],
                'help_block' => [
                    'text' => trans('admin.setting.help.dns_per_domain'),
                ]
            ])
            ->add('captcha_on_register', 'checkbox', [
                'label' => trans('admin.setting.field_captcha_on_register'),
                'value' => 1,
            ])
            ->add('captcha_on_login', 'checkbox', [
                'label' => trans('admin.setting.field_captcha_on_login'),
                'value' => 1,
            ])
            ->add('save', 'submit', [
                'label' => '<i class="fa fa-save"></i> ' . trans('button.save'),
                'attr' => [
                    'class' => 'btn btn-primary'
                ],
            ]);
    }
}
