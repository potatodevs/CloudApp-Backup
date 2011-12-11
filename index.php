<?php
/**
 * CloudApp Downloader
 *
 * @copyright   Copyright (c) 2011 Tomas Vitek, Yogesh Nagarur
 * @author      Tomas Vitek ~ http://tomik.jmx.cz

 * @version     0.1
 * @link        http://www.project135.com
 */

// Load Nette
require __DIR__ . '/libs/Nette/loader.php';

use Nette\Forms\Form,
    Nette\Diagnostics\Debugger,
    Nette\Utils\Html,
    Nette\Templating\FileTemplate;

// Debugger
Debugger::$strictMode = TRUE;
Debugger::$logDirectory = __DIR__ . '/log';
Debugger::enable();

$form = new Form;

$form->addText('login', 'CloudApp e-mail:')
        ->addRule($form::EMAIL, 'Not valid e-mail!')
        ->setRequired('Enter your CloudApp e-mail!');

$form->addPassword('password', 'CloudApp password:')
        ->setRequired('Enter your CloudApp password!');

$form->addSubmit('download', 'Download all my files!');

// Check if form was submitted?
if ($form->isSubmitted() && $form->isValid()) {
    require __DIR__ . '/libs/Cloud/API.php';
    require __DIR__ . '/libs/zip.php';
    require __DIR__ . '/libs/rrmdir.php';

    try {
        $cloudApp = new Cloud_API($form->values['login'], $form->values['password']);

        // getting info about the user's account
        $account = $cloudApp->getItem('http://my.cl.ly/account');

        $id = $account->id;

        $folder = __DIR__ . '/generated/' . $id;
        
        // temp folder
        if (is_dir($folder)) rrmdir($folder);
        mkdir($folder, 0777, true);
        
        // get all items
        $all_items = $cloudApp->getItems(1, PHP_INT_MAX);

        $files = array();

        // we dont want bookmarks, just files
        foreach ($all_items as $item) {
            if ($item->item_type != "bookmarks" && !empty ($item->remote_url)) {
                //copy($item->remote_url, $folder . '/' . $item->id . '-' . $item->name);
                $content = file_get_contents($item->remote_url);
                file_put_contents($folder . '/' . $item->id . '-' . $item->name, $content);                
                unset($content);
                $file = array();
                $file['path'] = $folder . '/' . $item->id . '-' . $item->name;
                $file['name'] = $item->id . '-' . $item->name;
                if (is_file($file['path'])) $files[] = $file;
            }
        }

        if (count($files) > 0) {
            // name of the archive
            $name = 'archive-' . $id . '.zip';

            $zip = create_zip($files, __DIR__ . '/generated/' . $name);
            
            // remove temp folder
            rrmdir($folder);            
            
            // inputs link to the archive
            $template = new FileTemplate('done.latte');
            $template->registerHelperLoader('Nette\Templating\DefaultHelpers::loader');
            $template->registerFilter(new Nette\Latte\Engine);
            $template->id = $id;
            $template->url = 'http://www.project135.com/generated/' . $name;
            $template->render();              
        }
        else {
            // remove temp folder
            rrmdir($folder);            
            
            // shows message that there is nothing to download
            $template = new FileTemplate('down.latte');
            $template->registerHelperLoader('Nette\Templating\DefaultHelpers::loader');
            $template->registerFilter(new Nette\Latte\Engine);
            $template->render();              
        }
    }
    catch (Cloud_Exception $e) {
        // show error
        $template = new FileTemplate('error.latte');
        $template->registerHelperLoader('Nette\Templating\DefaultHelpers::loader');
        $template->registerFilter(new Nette\Latte\Engine);
        $template->form = $form;
        $template->render();                
    }

} else {
    // show login form
    $template = new FileTemplate('form.latte');
    $template->registerHelperLoader('Nette\Templating\DefaultHelpers::loader');
    $template->registerFilter(new Nette\Latte\Engine);
    $template->form = $form;
    $template->render();
}    