using System;
using System.Collections.Generic;
using System.Linq;
using System.Text;
using System.Threading.Tasks;
using System.Windows;
using System.Windows.Controls;
using System.Windows.Data;
using System.Windows.Documents;
using System.Windows.Input;
using System.Windows.Media;
using System.Windows.Media.Imaging;
using System.Windows.Shapes;
using IUTGame;


namespace MaimLandProject.IHM
{
    /// <summary>
    /// Interaction logic for Window1.xaml
    /// </summary>

    public partial class Window1 : Window
    {
        

       
        public Window1()
        {
            InitializeComponent();
            volumeSlider.Value = App.GlobalVolume * 100;

        }

        private void Retour_menu(object sender, RoutedEventArgs e)
        {
            MainWindow mainWindow = new MainWindow();
            mainWindow.Show();
            this.Close();
        }

        private void Retour_jeu(object sender, RoutedEventArgs e)
        {
            MainWindow mainWindow = new MainWindow();
            mainWindow.Show();
            this.Close();
        }

        
        private void VolumeSlider_ValueChanged(object sender, RoutedPropertyChangedEventArgs<double> e)
        { 
            float nouveauVolume = (float)(volumeSlider.Value / 100.0f);
            App.GlobalVolume = nouveauVolume;

            //  Appliquer au son en cours 
            try
            {
                var musique = SoundStore.Get("song.mp3");
                if (musique != null)
                {
                    musique.Volume = nouveauVolume;
                }
            }
            catch { }

         

        }
    }
}
