# Get key from local filesystem and create a DigitalOcean SSH key resource
resource "digitalocean_ssh_key" "my-ssh-key" {
  name       = "My SSH Key"
  public_key = file(var.ssh_key_path)
}