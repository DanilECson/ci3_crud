HMVC scaffolding instructions
===========================

What I added
------------
- Created a modules scaffold under `application/modules/` for `auth`, `product`, and `dashboard`.
  - Controllers, models and views were copied from the existing app into matching module folders.

Next steps to enable HMVC (Modular Extensions / Wiredesignz)
---------------------------------------------------------
1. Obtain Modular Extensions (HMVC) by Wiredesignz.
   - Recommended: get the official package from its repository and use the appropriate release.

2. Install files into your application:
   - Copy the `MX` library into `application/third_party/MX/` (the package typically contains `Loader.php`, `Controller.php`, and `Modules.php`).

3. Update controllers to use `MX_Controller` (optional now):
   - Replace `class Foo extends CI_Controller` with `class Foo extends MX_Controller` in module controllers to take advantage of module loading.

4. Keep the existing controllers while you test.
   - The scaffolded module files are a drop-in copy for organization. Install the MX package, then switch the controller base class and test.

5. Test routing and views:
   - With MX installed, module controllers can call `$this->load->view('module_name/view')` and models can be loaded by `$this->load->model('module_name/model_name')`.

Suggested follow-ups
--------------------
- Switch controllers to extend `MX_Controller` (one-by-one) and run the app.
- Update `application/config/routes.php` if you want module-specific entrypoints.
- Consider enabling `application/config/config.php` CSRF protection and session hardening before deploying to production.

Notes
-----
- I did not modify the core loader or router in this commit; the repository now contains module copies only. Installing the MX files is required to make CI search `application/modules/` automatically.
