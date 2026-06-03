<?php

namespace Database\Seeders\DemoData;

use App\Library\Enum;
use App\Models\Page;
use App\Models\PageLanguage;
use Illuminate\Database\Seeder;

class PageSeeder extends Seeder
{
    public function run()
    {
        foreach ($this->data() as $data) {
            // dd($data['link']);

            $page = new Page();
            $page->operator_id = 1;
            $page->link = $data['link'];
            $page->save();

            $language_data['page_id'] = $page->id;
            $language_data['local'] = 'en';
            $language_data['title'] = $data['title'];
            $language_data['content'] = $data['content'];
            PageLanguage::create($language_data);

        }
    }

    private function data()
    {
        return [
            [
                'title'   => 'Return and Refund Policy',
                'content' => 'Where does it come from? Contrary to popular belief, Lorem Ipsum is not simply random text. It has roots in a piece of classical Latin literature from 45 BC, making it over 2000 years old. Richard McClintock, a Latin professor at Hampden-Sydney College in Virginia, looked up one of the more obscure Latin words, consectetur, from a Lorem Ipsum passage, and going through the cites of the word in classical literature, discovered the undoubtable source. Lorem Ipsum comes from sections 1.10.32 and 1.10.33 of "de Finibus Bonorum et Malorum" (The Extremes of Good and Evil) by Cicero, written in 45 BC. This book is a treatise on the theory of ethics, very popular during the Renaissance. The first line of Lorem Ipsum, "Lorem ipsum dolor sit amet..", comes from a line in section 1.10.32.',
                'link' => Enum::REFUND_POLICY,
            ],
            [
                'title'   => 'Support Policy',
                'content' => 'Where does it come from? Contrary to popular belief, Lorem Ipsum is not simply random text. It has roots in a piece of classical Latin literature from 45 BC, making it over 2000 years old. Richard McClintock, a Latin professor at Hampden-Sydney College in Virginia, looked up one of the more obscure Latin words, consectetur, from a Lorem Ipsum passage, and going through the cites of the word in classical literature, discovered the undoubtable source. Lorem Ipsum comes from sections 1.10.32 and 1.10.33 of "de Finibus Bonorum et Malorum" (The Extremes of Good and Evil) by Cicero, written in 45 BC. This book is a treatise on the theory of ethics, very popular during the Renaissance. The first line of Lorem Ipsum, "Lorem ipsum dolor sit amet..", comes from a line in section 1.10.32.',
                'link' => Enum::SUPPORT_POLICY,
            ],
            [
                'title'   => 'Terms & Condition',
                'content' => 'Where does it come from? Contrary to popular belief, Lorem Ipsum is not simply random text. It has roots in a piece of classical Latin literature from 45 BC, making it over 2000 years old. Richard McClintock, a Latin professor at Hampden-Sydney College in Virginia, looked up one of the more obscure Latin words, consectetur, from a Lorem Ipsum passage, and going through the cites of the word in classical literature, discovered the undoubtable source. Lorem Ipsum comes from sections 1.10.32 and 1.10.33 of "de Finibus Bonorum et Malorum" (The Extremes of Good and Evil) by Cicero, written in 45 BC. This book is a treatise on the theory of ethics, very popular during the Renaissance. The first line of Lorem Ipsum, "Lorem ipsum dolor sit amet..", comes from a line in section 1.10.32.',
                'link' => Enum::TERM_CONDITION,
            ],
            [
                'title'   => 'Privacy Policy',
                'content' => 'Where does it come from? Contrary to popular belief, Lorem Ipsum is not simply random text. It has roots in a piece of classical Latin literature from 45 BC, making it over 2000 years old. Richard McClintock, a Latin professor at Hampden-Sydney College in Virginia, looked up one of the more obscure Latin words, consectetur, from a Lorem Ipsum passage, and going through the cites of the word in classical literature, discovered the undoubtable source. Lorem Ipsum comes from sections 1.10.32 and 1.10.33 of "de Finibus Bonorum et Malorum" (The Extremes of Good and Evil) by Cicero, written in 45 BC. This book is a treatise on the theory of ethics, very popular during the Renaissance. The first line of Lorem Ipsum, "Lorem ipsum dolor sit amet..", comes from a line in section 1.10.32.',
                'link' => Enum::PRIVACY_POLICY,
            ],
            [
                'title'   => 'About Us',
                'content' => 'Where does it come from? Contrary to popular belief',
                'link' => Enum::ABOUT_US,
            ],
            [
                'title'   => 'Contact Us',
                'content' => 'Test Content',
                'link' => Enum::CONTACT_US,
            ],

        ];
    }
}
