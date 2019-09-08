using Microsoft.AspNetCore.Mvc;
using Serilog;

namespace EquipmentLoan.Controllers
{
    // [RoutePrefix("")]
    public class HomeController : Controller
    {
        [Route("")]
        public ActionResult Index()
        {
            return View();
        }

        [Route("About")]
        public ActionResult About()
        {
            return View();
        }

        [Route("Contact")]
        public ActionResult Contact()
        {
            return View();
        }

        public ActionResult Privacy()
        {
            return View();
        }

        [Route("Login")]
        public ActionResult Login()
        {
            return View();
        }
    }
}
