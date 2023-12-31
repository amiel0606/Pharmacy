using System;
using System.Collections.Generic;
using System.Linq;
using System.Text;
using System.Threading.Tasks;

namespace Pharmacy
{
    internal class dbCon
    {
        public string dbConString()
        {
            string con = @"Data Source=HEART;Initial Catalog=Pharmacy;Persist Security Info=True;User ID=amiel;Password=amiel";
            return con;
        }
    }
}
