<?php

return <<<TEMPLATE
uvdesk_mailbox:
    emails: ~
        # Often Reply emails like from gmail contains extra and redundant previous mail data.
        # This data can be removed by adding delimiter i.e. specific line before each reply. 
        # delimiter: '<-- Please add content above this line -->'
        # enable_delimiter: true
    
    # Configure your mailboxes here
    mailboxes:
[[ MAILBOXES ]]
TEMPLATE;

?>