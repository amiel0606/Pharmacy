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
    public partial class Form1 : Form
    {
        dbCon db = new dbCon();
        SqlConnection cn = new SqlConnection();
        SqlCommand cmd = new SqlCommand();
        SqlDataReader dr;
        public Form1()
        {
            InitializeComponent();
        }

        private void button1_Click(object sender, EventArgs e)
        {
            cn = new SqlConnection(db.dbConString());
            cn.Open();
            cmd = new SqlCommand("SELECT * FROM tblUsers WHERE Role = @role AND userName = @username AND pass = @pass", cn);
            cmd.Parameters.AddWithValue("@role", comboBox1.Text);
            cmd.Parameters.AddWithValue("@username", txtUser.Text);
            cmd.Parameters.AddWithValue("@pass", txtPass.Text);
            dr = cmd.ExecuteReader();
            if (dr.Read())
            {
                if (dr["Role"].ToString() == "Admin")
                {
                    MessageBox.Show("Login Success!");
                    Menu menu = new Menu();
                    menu.Show();
                    this.Hide();
                    menu.button4.Visible = true;
                    menu.button2.Visible = true;
                }
                else if (dr["Role"].ToString() == "Employee")
                {
                    MessageBox.Show("Login Success!");
                    Menu menu = new Menu();
                    menu.Show();
                    this.Hide();
                    menu.button4.Visible = false;
                    menu.button2.Visible = false;
                }
            }
            else
            {
                MessageBox.Show("Invalid Login!");
            }
            cn.Close();
        }
    }
}
