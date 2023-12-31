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
    public partial class AddProduct : Form
    {
        dbCon db = new dbCon();
        SqlConnection cn = new SqlConnection();
        SqlCommand cmd = new SqlCommand();
        Inventory inv;
        public AddProduct(Inventory inve)
        {
            InitializeComponent();
            cn = new SqlConnection(db.dbConString());
            inv = inve;
        }

        public void Clear()
        {
            txtBarcode.Clear();
            txtBrandName.Clear();
            txtDesc.Clear();
            txtExp.Clear();
            txtQty.Clear();
        }

        private void btnAdd_Click(object sender, EventArgs e)
        {
            try
            {
                if (!string.IsNullOrEmpty(txtBarcode.Text) && !string.IsNullOrEmpty(txtBrandName.Text) && !string.IsNullOrEmpty(txtDesc.Text) && !string.IsNullOrEmpty(txtExp.Text) && !string.IsNullOrEmpty(txtQty.Text) && !string.IsNullOrEmpty(txtPrice.Text))
                {
                    if (MessageBox.Show("Add this Product?", "Confirm", MessageBoxButtons.YesNo, MessageBoxIcon.Question) == DialogResult.Yes)
                    {
                        cn.Open();
                        cmd = new SqlCommand("INSERT INTO tblProducts (barcode, brand, description, expiryDate, stocks, price) VALUES (@barcode, @brand, @description, @expiryDate, @stocks, @price)", cn);
                        cmd.Parameters.AddWithValue("@price", txtPrice.Text);
                        cmd.Parameters.AddWithValue("@barcode", txtBarcode.Text);
                        cmd.Parameters.AddWithValue("@brand", txtBrandName.Text);
                        cmd.Parameters.AddWithValue("@description", txtDesc.Text);
                        cmd.Parameters.AddWithValue("@expiryDate", txtExp.Text);
                        cmd.Parameters.AddWithValue("@stocks", txtQty.Text);
                        cmd.ExecuteNonQuery();
                        cn.Close();
                        inv.LoadProducts();
                        MessageBox.Show("Product Added!");
                        this.Dispose();
                        Clear();
                    }
                    else
                    {
                        MessageBox.Show("Cancelled");
                        cn.Close();
                    }
                }
                else
                {
                    MessageBox.Show("Please fill up all fields!");
                }
            }
            catch (Exception ex)
            {
                MessageBox.Show(ex.Message);
            }
        }

        private void btnUpdate_Click(object sender, EventArgs e)
        {
            try
            {
                if (!string.IsNullOrEmpty(txtBarcode.Text) && !string.IsNullOrEmpty(txtBrandName.Text) && !string.IsNullOrEmpty(txtDesc.Text) && !string.IsNullOrEmpty(txtExp.Text) && !string.IsNullOrEmpty(txtQty.Text) && !string.IsNullOrEmpty(txtPrice.Text))
                {
                    if (MessageBox.Show("Are you sure you want to update this product?", "Update Record", MessageBoxButtons.YesNo, MessageBoxIcon.Question) == DialogResult.Yes)
                    {
                        cn.Open();
                        cmd = new SqlCommand("UPDATE tblProducts SET barcode = @barcode, brand = @brand, description = @description, expiryDate = @expiryDate, stocks = @stocks, price = @price WHERE productID = @id", cn);
                        cmd.Parameters.AddWithValue("@id", lblD.Text);
                        cmd.Parameters.AddWithValue("@barcode", txtBarcode.Text);
                        cmd.Parameters.AddWithValue("@brand", txtBrandName.Text);
                        cmd.Parameters.AddWithValue("@description", txtDesc.Text);
                        cmd.Parameters.AddWithValue("@expiryDate", txtExp.Text);
                        cmd.Parameters.AddWithValue("@stocks", txtQty.Text);
                        cmd.Parameters.AddWithValue("@price", txtPrice.Text);
                        cmd.ExecuteNonQuery();
                        cn.Close();
                        MessageBox.Show("Product Updated!");
                        inv.LoadProducts();
                        this.Dispose();
                    }
                    else
                    {
                        MessageBox.Show("Cancelled");
                        cn.Close();
                    }
                }
                else
                {
                    MessageBox.Show("Please fill up all fields!");
                }
            }
            catch (Exception ex)
            {
                MessageBox.Show(ex.Message);
            }
        }
    }
}
