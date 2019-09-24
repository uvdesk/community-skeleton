<?php

return <<<PROMPT

<bg=blue>                                                                 </>
<bg=blue;fg=white;>   Bootstrapping your UVDesk Community Helpdesk Support System   </>
<bg=blue>                                                                 </>

Before continuing, first ensure that you have correctly configured your application 
as detailed below under the <fg=blue;options=bold;>Base Configuration</> guide.

Once you have correctly setup your application with the minimum set of configuration 
parameters, your support system is ready to be used. Follow along the steps detailed 
under the <fg=blue;options=bold;>Running your application</> guide to start using your project.

  * <fg=blue;options=bold;>Base Configuration:</>

    1. Switch to the project directory
    2. Modify your DATABASE_URL config in <info>.env</info>
    3. Execute the <comment>php bin/console uvdesk:configure-helpdesk</comment> command
    
       This will populate your database with the necessary dataset required by different
       components in your application for proper functioning of your support system.

  * <fg=blue;options=bold;>Running your Application:</>

    1. Switch to the project directory
    2. Execute the <comment>php bin/console server:run</> command to start the development server
    3. Browse to <comment>http://127.0.0.1:8000/en/member/login</> url to access your support dashboard.

       Quit the server with CTRL-C.
    
PROMPT;

?>