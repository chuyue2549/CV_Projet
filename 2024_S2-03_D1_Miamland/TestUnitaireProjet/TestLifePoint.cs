using System;
using System.Collections.Generic;
using System.Linq;
using System.Text;
using System.Threading.Tasks;
using IUTGame.Fake;
using MaimLandProject.Metier;

namespace TestUnitaireProjet
{
    public class TestLifePoint
    {
        [Fact]
        public void Test_PerdreVie()
        {
            FakeScreen screen = new FakeScreen();
            LeJeu jeu = new LeJeu(screen);
            LifePoint pv = new LifePoint(3,10,10,jeu);

            pv.PerdreVie();

            Assert.Equal(2, pv.Vie); 

        }
    }
}
