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
    public partial class addEmp : Form
    {
        dbCon db = new dbCon();
        SqlConnection cn = new SqlConnection();
        SqlCommand cmd = new SqlCommand();
        SqlDataReader dr;
        public addEmp()
        {
            InitializeComponent();
            cn = new SqlConnection(db.dbConString());
            LoadUsers(); // HAHAHAHAHHAHAUSHDUHAWUHDSHDOWJAPIOSKDPIASIPDIWAJIUSJDIWJAIJSIDWIPASIPDKKPA
        }

        private void button2_Click(object sender, EventArgs e)
        {
            AddEmployee addEmployee = new AddEmployee(this);
            addEmployee.Show();
        }

        public void LoadUsers()
        {
            int i = 0;
            dataGridView1.Rows.Clear();
            cn.Open();
            cmd = new SqlCommand("SELECT * FROM tblUsers", cn);
            dr = cmd.ExecuteReader();
            while (dr.Read())
            {
                i++;
                dataGridView1.Rows.Add(i, dr["uID"].ToString(), dr["userName"].ToString(), dr["fName"].ToString(), dr["lName"].ToString(), dr["role"].ToString(), dr["pass"]);
            }
            dr.Close();
            cn.Close();
        }

        private void dataGridView1_CellContentClick(object sender, DataGridViewCellEventArgs e)
        {
            string colName = dataGridView1.Columns[e.ColumnIndex].Name;
            if (colName == "edit")
            {
                AddEmployee editUser = new AddEmployee(this);
                editUser.lblD.Text = dataGridView1.Rows[e.RowIndex].Cells[1].Value.ToString();
                editUser.txtUser.Text = dataGridView1.Rows[e.RowIndex].Cells[2].Value.ToString();
                editUser.txtFname.Text = dataGridView1.Rows[e.RowIndex].Cells[3].Value.ToString();
                editUser.txtLname.Text = dataGridView1.Rows[e.RowIndex].Cells[4].Value.ToString();
                editUser.cmbRole.Text = dataGridView1.Rows[e.RowIndex].Cells[5].Value.ToString();
                editUser.txtPass.Text = dataGridView1.Rows[e.RowIndex].Cells[6].Value.ToString();
                editUser.Show();
            }
            else if (colName == "delete")
            {
                if (MessageBox.Show("Are you sure you want to delete this user?", "Delete User", MessageBoxButtons.YesNo, MessageBoxIcon.Question) == DialogResult.Yes)
                {
                    cn.Open();
                    cmd = new SqlCommand("DELETE FROM tblUsers WHERE uID like '" + dataGridView1.Rows[e.RowIndex].Cells[1].Value.ToString() + "'", cn);
                    cmd.ExecuteNonQuery();
                    cn.Close();
                    MessageBox.Show("User Deleted!");
                    LoadUsers();
                }
            }
        }
    }
}
