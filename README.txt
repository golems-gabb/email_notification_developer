Email notification developer
-----------------
    1) Provides the ability to track the change of domain name owner resource.
        Field of use: for your portfolio, or if the customer has not paid the
        unscrupulous to work and changed admin Email, and you do not know how
        to find you developed resource
    2) Allows you to notify administrators about errors that arose on the site
    for whatever reason: (a bug, or change the version php customer).
    Both functions are independent. They can activate together, separately
    or altogether eliminate

 Usage
 ------
  On the Settings page admin/config/development/developer/domain
  We specify the following options:
  Checkboxes "Activate functionality" - activates the functional check of the
  domain name change.
  In the field "The period of inspection" is set during functional activation
  after running crown. Functionality will be triggered only when the elapsed 
  time equals or is greater than the start of last day functional.
  The field "Domain list" - contains a list of available domains used.
  The field "Emails list" - right up to 10 email addresses, which will receive
  information about changing the domain name of the resource.

  On the Settings page admin/config/development/developer/error
  We specify the following options:
  Checkboxes "Activate functionality" - activates the functional check error
  In the field "The period of inspection" is set during functional activation
  after running crown. Functionality will be triggered only when the elapsed
  time equals or is greater than the start of last day functional.
  logs on the site, and if they detect inform developers about them.
  The field "Emails list" - right up to 10 email addresses, which will receive
  information about changing the domain name of the resource.
  
  Email messages for the domain name change and error messages are independent
  and are sent separately.
