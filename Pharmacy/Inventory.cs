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
    public partial class Inventory : Form
    {
        dbCon db = new dbCon();
        SqlConnection cn = new SqlConnection();
        SqlCommand cmd = new SqlCommand();
        SqlDataReader dr;
        public Inventory()
        {
            InitializeComponent();
            cn = new SqlConnection(db.dbConString());
            LoadProducts();
        }

        private void button2_Click(object sender, EventArgs e)
        {
            AddProduct addProduct = new AddProduct(this);
            addProduct.Show();
        }

        public void LoadProducts()
        {
            int i = 0;
            dataGridView1.Rows.Clear();
            cn.Open();
            cmd = new SqlCommand("SELECT * FROM tblProducts", cn);
            dr = cmd.ExecuteReader();
            dataGridView1.Columns["expDate"].DefaultCellStyle.Format = "yyyy/MM/dd";
            while (dr.Read())
            {
                i++;
                dataGridView1.Rows.Add(i, dr["productID"].ToString(), dr["brand"].ToString() + " " + dr["description"].ToString(), dr["description"].ToString(), dr["brand"].ToString(), dr["barcode"].ToString(), dr["price"].ToString(), dr["stocks"].ToString(), dr["expiryDate"]);
            }
            dr.Close();
            cn.Close();
        }

        private void dataGridView1_CellContentClick(object sender, DataGridViewCellEventArgs e)
        {
            string colname = dataGridView1.Columns[e.ColumnIndex].Name;
            if (colname == "edit")
            {
                if (MessageBox.Show("Update this Product?", "Confirm", MessageBoxButtons.YesNo, MessageBoxIcon.Question) == DialogResult.Yes)
                {
                    AddProduct editProduct = new AddProduct(this);
                    editProduct.btnAdd.Visible = false;
                    editProduct.btnUpdate.Visible = true;
                    editProduct.lblD.Text = dataGridView1.Rows[e.RowIndex].Cells[1].Value.ToString();
                    editProduct.txtDesc.Text = dataGridView1.Rows[e.RowIndex].Cells[3].Value.ToString();
                    editProduct.txtBrandName.Text = dataGridView1.Rows[e.RowIndex].Cells[4].Value.ToString();
                    editProduct.txtBarcode.Text = dataGridView1.Rows[e.RowIndex].Cells[5].Value.ToString();
                    editProduct.txtBarcode.Enabled = false;
                    editProduct.txtPrice.Text = dataGridView1.Rows[e.RowIndex].Cells[6].Value.ToString();
                    editProduct.txtQty.Text = dataGridView1.Rows[e.RowIndex].Cells[7].Value.ToString();
                    editProduct.txtExp.Text = Convert.ToDateTime(dataGridView1.Rows[e.RowIndex].Cells[8].Value).ToString("yyyy/MM/dd");
                    editProduct.Show(); 
                }
            }
            else if (colname == "delete")
            {
                if (MessageBox.Show("Delete this Product?", "Confirm", MessageBoxButtons.YesNo, MessageBoxIcon.Question) == DialogResult.Yes)
                {
                    cn.Open();
                    cmd = new SqlCommand("DELETE FROM tblProducts WHERE productID = @id", cn);
                    cmd.Parameters.AddWithValue("@id", dataGridView1.Rows[e.RowIndex].Cells[1].Value.ToString());
                    cmd.ExecuteNonQuery();
                    cn.Close();
                    LoadProducts();
                    MessageBox.Show("Product Deleted!");
                }
            }
        }

        public void searchProducts()
        {
            int i = 0;
            dataGridView1.Rows.Clear();
            cn.Open();
            string search = txtSearch.Text;
            string query = "SELECT * FROM tblProducts WHERE brand LIKE @search OR description LIKE @search OR barcode LIKE @search";
            SqlCommand cmd = new SqlCommand(query, cn);
            cmd.Parameters.AddWithValue("@search", "%" + search + "%");
            dr = cmd.ExecuteReader();
            dataGridView1.Columns["expDate"].DefaultCellStyle.Format = "yyyy/MM/dd";
            while (dr.Read())
            {
                i++;
                dataGridView1.Rows.Add(i, dr["productID"].ToString(), dr["brand"].ToString() + " " + dr["description"].ToString(), dr["description"].ToString(), dr["brand"].ToString(), dr["barcode"].ToString(), dr["price"].ToString(), dr["stocks"].ToString(), dr["expiryDate"]);
            }
            dr.Close();
            cn.Close();
        }

        private void txtSearch_TextChanged(object sender, EventArgs e)
        {
            searchProducts();
        }
    }
}
