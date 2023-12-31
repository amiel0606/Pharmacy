using System;
using System.Collections.Generic;
using System.ComponentModel;
using System.Data;
using System.Data.SqlClient;
using System.Drawing;
using System.Linq;
using System.Text;
using System.Threading.Tasks;
using System.Windows.Forms;

namespace Pharmacy
{
    public partial class AddEmployee : Form
    {
        dbCon db = new dbCon();
        SqlConnection cn = new SqlConnection();
        SqlCommand cmd = new SqlCommand();
        addEmp emp;
        public AddEmployee(addEmp empl)
        {
            InitializeComponent();
            cn = new SqlConnection(db.dbConString());
            emp = empl;
        }

        private void showPass_CheckedChanged(object sender, EventArgs e)
        {
            if (showPass.Checked)
            {
                txtPass.UseSystemPasswordChar = false;
            }
            else
            {
                txtPass.UseSystemPasswordChar = true;
            }
        }

        private void button2_Click(object sender, EventArgs e)
        {
            cn.Open();
            cmd = new SqlCommand("INSERT INTO tblUsers(Role, userName,  pass, fName, lName) VALUES (@role, @username, @pass, @fName, @lName)", cn);
            cmd.Parameters.AddWithValue("@fName", txtFname.Text);
            cmd.Parameters.AddWithValue("@lName", txtLname.Text);
            cmd.Parameters.AddWithValue("@role", cmbRole.Text);
            cmd.Parameters.AddWithValue("@username", txtUser.Text);
            cmd.Parameters.AddWithValue("@pass", txtPass.Text);
            cmd.ExecuteNonQuery();
            cn.Close();
            MessageBox.Show("User Added!");
            emp.LoadUsers();
            this.Hide();
        }
    }
}
