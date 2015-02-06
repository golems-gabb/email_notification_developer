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
  On the Settings page admin/config/developer
  We specify the following options:
  Cheksboks "Activate functionality" - activates the functional check of the
  domain name change.
  The field "Domain list" - contains a list of available domains used.
  The field "Emails list" - right up to 10 email adresses, which will receive
  information about changing the domain name of the resource.

  On the Settings page admin/config/developer/error
  We specify the following options:
  Cheksboks "Activate functionality" - activates the functional check error
  logs on the site, and if they detect inform developers about them.
  Field "The period of inspection" - a term wear send information to both pages,
   check that domain name and message for Email and error messages on the site.
  The field "Emails list" - right up to 10 email adresses, which will receive
  information about changing the domain name of the resource.
  
  Email messages for the domain name change and error messages are independent
  and are sent separately.
